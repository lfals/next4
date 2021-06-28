<?php

namespace YOOtheme\Wordpress;

use YOOtheme\Database\AbstractDatabase;

class Database extends AbstractDatabase
{
    /**
     * @var \wpdb
     */
    protected $db;

    /**
     * Constructor.
     *
     * @param \wpdb $db
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->prefix = $db->get_blog_prefix();
        $this->driver = isset($db->is_mysql) ? 'mysql' : null;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($statement, array $params = [])
    {
        return $this->db->get_results($this->prepareQuery($statement, $params), ARRAY_A);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAssoc($statement, array $params = [])
    {
        return $this->db->get_row($this->prepareQuery($statement, $params), ARRAY_A);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchArray($statement, array $params = [])
    {
        return $this->db->get_row($this->prepareQuery($statement, $params), ARRAY_N);
    }

    /**
     * {@inheritdoc}
     */
    public function executeQuery($query, array $params = [])
    {
        return $this->db->query($this->prepareQuery($query, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function insert($table, $data)
    {
        return $this->db->insert($this->replacePrefix($table), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function update($table, $data, $identifier)
    {
        return $this->db->update($this->replacePrefix($table), $data, $identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($table, $identifier)
    {
        return $this->db->delete($this->replacePrefix($table), $identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function escape($text)
    {
        return "'{$this->db->_escape($text)}'";
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId()
    {
        return $this->db->insert_id;
    }
}
