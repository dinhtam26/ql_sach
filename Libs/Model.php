<?php
class Model
{
    protected $connect;
    protected $database;
    protected $table;
    protected $resultQuery;

    public function __construct($params = null)
    {
        if ($params == null) {
            $params['server']       = DB_HOST;
            $params['username']         = DB_USER;
            $params['password']     = DB_PASSWORD;
            $params['dbname']       = DB_DATABASE;
            $params['table']        = DB_TABLE;
        }
        $link = mysqli_connect($params['server'], $params['username'], $params['password'], $params['dbname']);
        if (!$link) {
            die('Fail connect');
        } else {
            $this->connect  = $link;
            $this->database = $params['dbname'];
            $this->table    = $params['table'];
        }
    }

    //  SET CONNECT
    public function setConnect($connect)
    {
        $this->connect = $connect;
    }

    // SET TABLE
    public function setTable($table)
    {
        $this->table  = $table;
    }

    // DISCONNECT DATABASE
    // public function __destruct()
    // {
    //     mysqli_close($this->connect);
    // }



    // INSERT

    public function insert($data, $type = "single")
    {

        if ($type == "single") {
            $newQuery = $this->createInsertSQL($data);
            $query = "INSERT INTO $this->table(" . $newQuery['cols'] . ") VALUE(" . $newQuery['values'] . ")";
            $this->query($query);
        } else {
            foreach ($data as $value) {
                $newQuery = $this->createInsertSQL($value);
                $sql = "INSERT INTO $this->table(" . $newQuery['cols'] . ") VALUE(" . $newQuery['values'] . ")";
                $this->query($sql);
            }
        }
        return $this->lastId();
    }


    // CREATE INSERT SQL 
    public function createInsertSQL($data)
    {
        $newQuery = [];
        $cols = $values =  "";
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $cols .=  ", `$key`";
                $values .= ", '$value'";
            }
            $newQuery["cols"] = substr($cols, 2);
            $newQuery["values"] = substr($values, 2);
        }
        return $newQuery;
    }

    // METHOD QUERY
    public function query($query)
    {
        $this->resultQuery = mysqli_query($this->connect, $query);
        return $this->resultQuery;
    }
    // LAST ID
    public function lastId()
    {
        return mysqli_insert_id($this->connect);
    }

    // CREATE UPDATE SQL
    public function createUpdate($data)
    {
        $newQuery = "";
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $newQuery .=  ", $key = '$value'";
            }
            $newQuery = substr($newQuery, 2);
            return $newQuery;
        }
    }

    // METHOD UPDATE
    public function update($data, $where)
    {
        $newQuery = $this->createUpdate($data);
        $newQueryWhere = $this->createWhereUpdateSql($where);

        $sql = "UPDATE $this->table SET $newQuery
               WHERE $newQueryWhere";

        $this->query($sql);
        return $this->affectedRows();
    }
    // CREATE WHERE SQL
    public function createWhereUpdateSql($data)
    {
        $newWhere = [];
        if (!empty($data)) {
            foreach ($data as  $value) {
                $newWhere[] = " `$value[0]` = '$value[1]' ";
                if (isset($value[2])) {
                    $newWhere[] =  $value[2];
                }
            }

            $newWhere = implode(" ", $newWhere);
        }
        return $newWhere;
    }

    // AFFECTED ROWS:Trả về tổng số dòng vừa thực hiện
    public function affectedRows()
    {
        return mysqli_affected_rows($this->connect);
    }

    // DELETE

    public function delete($where)
    {
        $query = "DELETE FROM `$this->table` WHERE id = $where";
        $this->query($query);
        return $this->affectedRows();
    }


    public function multiDelete($where)
    {
        $newWhere  = $this->createWhereDeleteSql($where);
        $query = "DELETE FROM `$this->table` WHERE id IN ($newWhere)";
        $this->query($query);
        return $this->affectedRows();
    }

    // CREATE WHERE DELETE SQL
    public function createWhereDeleteSql($data)
    {
        $newWhere = "";
        if (!empty($data)) {
            foreach ($data as $id) {
                $newWhere .= "'" . $id . "', ";
            }
            $newWhere = rtrim($newWhere, ", ");
        }
        return $newWhere;
    }

    // LIST RECORD
    public function listRecord($query)
    {
        $result = [];
        if (!empty($query)) {
            $resultQuery = $this->query($query);
        }
        if (mysqli_num_rows($resultQuery) > 0) {
            $row = mysqli_fetch_all($resultQuery, MYSQLI_ASSOC);
            $result = $row;
        }
        mysqli_free_result($resultQuery);
        return $result;
    }

    public function listSelect($query, $name, $keySelect = null)
    {
        $result = [];
        if (!empty($query)) {
            $resultQuery = $this->query($query);
        }
        $xhtml = "";
        if (mysqli_num_rows($resultQuery) > 0) {
            $row = mysqli_fetch_all($resultQuery, MYSQLI_ASSOC);

            $xhtml .= ' <select name="' . $name . '" id="' . $name . '">';
            $xhtml .= '<option value="0" >Select a value</option>';
            foreach ($row as $key => $value) {
                $keyword = $value['id'];
                if ($keyword == $keySelect && $keySelect != null) {
                    $xhtml .= '<option value="' . $keyword . '" selected = "selected" >' . $value['name'] . '</option>';
                } else {
                    $xhtml .= '<option value="' . $keyword . '">' . $value['name'] . '</option>';
                }
            }
            $xhtml .= '</select>';
        }
        mysqli_free_result($resultQuery);
        return  $xhtml;;
    }

    // SINGLE RECORD
    public function singleRecord($query)
    {
        $result = [];
        if (!empty($query)) {
            $resultQuery = $this->query($query);
        }

        if (mysqli_num_rows($resultQuery) > 0) {
            $row = mysqli_fetch_assoc($resultQuery);
            $result = $row;
        }
        mysqli_free_result($resultQuery);
        return $result;
    }

    // EXITS
    public function exits($query)
    {
        if ($query != null) {
            $this->resultQuery = $this->query($query);
        }
        if (mysqli_num_rows($this->resultQuery) > 0)   return true;

        return false;
    }

    public function find($id)
    {
        $result = [];
        // Tránh tấn công sql
        $id = mysqli_real_escape_string($this->connect, $id);
        $sqlFind = "SELECT * FROM `$this->table` WHERE id = $id";
        $resultQuery  = $this->query($sqlFind);
        $result = mysqli_fetch_assoc($resultQuery);
        return $result;
    }
}
