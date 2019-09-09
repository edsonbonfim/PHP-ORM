<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use stdClass;

class QueryBuilder extends ActiveRecord
{
    private $class = null;
    private $select = '*';
    private $where = [];
    private $table = null;
    private $limit = null;
    private $order = '';
    private $union = null;
    private $insert = null;
    private $values = null;

    public function __construct($class = null)
    {
        $this->where = [
            'column' => 1,
            'value'  => []
        ];
        $this->class = $class;
    }

    public function select($columns): self
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $this->select = "$columns";

        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string $column
     * @param $value
     * @param string $op
     * @param string $cond
     * @return QueryBuilder
     */
    public function where(string $column, $value, string $op = '=', string $cond = 'AND'): self
    {
        $this->where['column'] .= " $cond $column ";

        if ($value) {
            $this->where['column'] .= "$op ? ";
            $this->where['value'][] = $value;
        }

        return $this;
    }

    public function in(string $column, $query, $cond = 'AND'): self
    {
        if ($query instanceof \Closure) {
            $class = __CLASS__;
            $query = $query(new $class);
        }

        $this->where['column'] .= " $cond $column in ({$query->getSelectQuery()})";
        $this->where['value'] = array_values(array_merge($this->where['value'], $query->getValues()));

        return $this;
    }

    public function notIn(string $column, $query, $cond = 'AND'): self
    {
        $this->where['column'] .= " $cond $column not in ({$query->getSelectQuery()})";
        $this->where['value'] = array_values(array_merge($this->where['value'], $query->getValues()));
        return $this;
    }

    public function join($table1, $table2, $assoc): self
    {
        $this->from("$table1, $table2");
        $this->where("$table1.$assoc = $table2.id", null);
        return $this;
    }

    public function union($query): self
    {
        if ($query instanceof \Closure) {
            $class = __CLASS__;
            $query = $query(new $class);
        }

        $this->union = $query->getSelectQuery();
        $this->where['value'] = array_values(array_merge($this->where['value'], $query->getValues()));

        return $this;
    }

    public function limit(int $n): self
    {
        $this->limit = $n;
        return $this;
    }

    public function rand(): self
    {
        $this->order = 'RAND()';
        return $this;
    }

    public function order($expression): self
    {
        $this->order = $expression;
        return $this;
    }

    /**
     * @return static[]|stdClass[]|null
     */
    public function get()
    {
        $res = $this->execute($this->getSelectQuery(), $this->where['value'])->fetchAll(\PDO::FETCH_OBJ);

        if (!$res) {
            return null;
        }

        if ($this->class === null) {
            return $res;
        }

        $array = [];

        foreach ($res as $row) {
            $class = $this->class;
            $class = new $class;

            foreach ($row as $key => $value) {
                $class->$key = $value;
            }

            $array[] = $class;
        }


        return $array;
    }


    /**
     * @return static|null
     */
    public function first()
    {
        $this->limit(1);

        $res = $this->execute($this->getSelectQuery(), $this->where['value'])->fetch(\PDO::FETCH_OBJ);

        if (!$res) {
            return null;
        }

        if ($this->class === null) {
            return $res;
        }

        $class = $this->class;
        $class = new $class;

        foreach ($res as $key => $value) {
            $class->$key = $value;
        }

        return $class;
    }

    public function find($id)
    {
        $this->where('id', $id);
        return $this->first();
    }

    public function last()
    {
        return $this->order('id DESC')->first();
    }

    public function count()
    {
        $this->select('count(id) as count');
        return (int) $this->first()->count;
    }

    public function max(string $column)
    {
        $this->select("max($column) as max");
        return (int) $this->first()->max;
    }

    public function min(string $column)
    {
        $this->select("min($column) as min");
        return (int) $this->first()->min;
    }

    public function avg(string $column)
    {
        $this->select("avg($column) as avg");
        return (int) $this->first()->avg;
    }

    public function into(string $table): self
    {
        $this->from($table);
        return $this;
    }

    public function insert(array $data)
    {
        $query  = "INSERT INTO $this->table (";
        $query .= implode(', ', array_keys($data));
        $query .= ') VALUES (';

        $values = array_values($data);

        $data = array_map(function () {
            return '?';
        }, $data);

        $query .= implode(', ', $data);
        $query .= ')';

        $this->execute($query, $values);

        return $this->find($this->lastInsertId());
    }

    public function delete()
    {
        $query = "DELETE FROM $this->table WHERE {$this->where['column']}";
        return $this->execute($query, $this->where['value'])->rowCount();
    }

    public function exists()
    {
        return $this->count() > 0 ? true : false;
    }

    public function getSelectQuery()
    {
        $query  = "SELECT $this->select FROM $this->table ";
        $query .= "WHERE {$this->where['column']} ";

        if (!empty($this->order)) {
            $query .= "ORDER BY $this->order ";
        }

        if ($this->limit) {
            $query .= "LIMIT $this->limit ";
        }

        if ($this->union) {
            $query .= "UNION ($this->union)";
        }

        return trim($query);
    }

    public function getValues()
    {
        return $this->where['value'];
    }
}
