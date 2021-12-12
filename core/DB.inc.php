<?php

class DB
{
    protected  $pdo;
    protected  $dbName;

    public function  __construct($host, $user, $pass, $dbname)
    {
        $this->dbName = $dbname;
        $this->pdo = new PDO("mysql:host={$host};bdName={$dbname};charset=utf8", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function getSQLWhere($conditions)
    {
        $conditionsParts=array();
        foreach($conditions as $key=>$values) {
            array_push($conditionsParts,"({$key}='{$values}')");
        }
        $conditionsStr = implode(" AND", $conditionsParts);
        return $conditionsStr;
    }

    public function delete($table, $conditions)
    {
        $conditionsStr = $this->getSQLWhere($conditions);
        $sql = "DELETE FROM {$this->dbName}.{$table} WHERE {$conditionsStr}";
        $state = $this->pdo->prepare($sql);
        $state->execute();
    }

    public function insert($table, $rows){
        $valuesStr="";
        $fieldsArr = array_keys($rows);
        $valuesArr = array_values($rows);
        $fields = implode(', ', $fieldsArr);
        foreach ($valuesArr as $value)
        {
            $valuesStr=$valuesStr." \"".htmlentities($value,ENT_QUOTES)."\",";
        }
        $valuesStr=substr($valuesStr, 0,strlen($valuesStr)-1);
        $sql = "INSERT INTO {$this->dbName}.{$table} ({$fields}) VALUES ({$valuesStr})";
        $state = $this->pdo->query($sql);
    }

    public function update($table, $conditions, $rows, $allowFields)
    {
        $conditionsStr = $this->getSQLWhere($conditions);
        $updatesStr='';
        foreach ($rows as $key=>$value)
        {
            if(in_array($key, $allowFields))
                $updatesStr= $updatesStr.", ".$key." = \"".htmlentities($value, ENT_QUOTES)."\"";
        }
        $updatesStr = substr($updatesStr, 1);
        $sql = "UPDATE {$this->dbName}.{$table} SET {$updatesStr} WHERE {$conditionsStr}";
        $state = $this->pdo->query($sql);
    }

    public function addRecordFromForm($table, $formRows, $allowFields)
    {
        $formNewRows = array();
        foreach ($formRows as $key=>$value)
        {
            if(in_array($key, $allowFields))
                $formNewRows[$key] = $value;
        }

        $this->insert($table,$formNewRows);
    }

    public function getRowsCount($table, $conditions='')
    {
        if($conditions!='') {
            $conditionsStr = $this->getSQLWhere($conditions);
        $sql = "SELECT COUNT(*) as count FROM {$this->dbName}.{$table} WHERE {$conditionsStr}";
        }else{
            $sql = "SELECT COUNT(*) as count FROM {$this->dbName}.{$table}";
        }
        $state = $this->pdo->query($sql);
        return (int)$state->fetch()['count'];
    }

    public function getRowsCountByCondition($table, $conditions)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->dbName}.{$table} {$conditions}";
        $state = $this->pdo->query($sql);
        return (int)$state->fetch()['count'];
    }

    public function getRowCountByCondition($table, $row, $conditions)
    {
        $sql = "SELECT {$this->dbName}.{$table}.{$row}, COUNT(*) as count FROM {$this->dbName}.{$table} {$conditions}";
        $state = $this->pdo->query($sql);
        $result = $state->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getConditionCountByCondition($table, $row, $conditions)
    {
        $sql = "SELECT {$row}, COUNT(*) as count FROM {$this->dbName}.{$table} {$conditions}";
        $state = $this->pdo->query($sql);
        $result = $state->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRowWhere($table, $row, $conditions)
    {
        $conditionsStr = $this->getSQLWhere($conditions);
        $sql = "SELECT {$row} FROM {$this->dbName}.{$table} WHERE {$conditionsStr} ORDER BY 'Id'";
        $state = $this->pdo->query($sql);
        return $state->fetch()[$row];
    }

    public function getRowsWhere($table, $conditions='', $limit=0, $offset=0, $rows='*')
    {
        $limitStr='LIMIT '.$limit.' OFFSET '.$offset.'';
        if($limit===0)
            $limitStr="";
        if($conditions!='') {
            $conditionsStr = $this->getSQLWhere($conditions);
            $sql = "SELECT {$rows} FROM {$this->dbName}.{$table} WHERE {$conditionsStr} ORDER BY Id DESC {$limitStr}";
        }
        else{
            $sql = "SELECT {$rows} FROM {$this->dbName}.{$table}  ORDER BY Id DESC  {$limitStr}";
        }
        $state = $this->pdo->query($sql);
        return $state->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRowsLike($table, $param, $fields)
    {
        $result=array();
        foreach ($fields as $key)
        {
            $sql = "SELECT * FROM {$this->dbName}.{$table} WHERE {$key} LIKE '%".$param."%'";
            $state = $this->pdo->query($sql);
            $res = $state->fetchAll(PDO::FETCH_ASSOC);
            $result = array_merge($result,$res);
        }
        return array_unique($result, SORT_REGULAR);;
    }

    public function incrementFieldWhere($table, $condition, $field)
    {
        $conditionsStr = $this->getSQLWhere($condition);
        $sql = "UPDATE {$this->dbName}.{$table} SET {$field} = {$field} + 1 WHERE {$conditionsStr}";
        $state = $this->pdo->query($sql);
    }


}