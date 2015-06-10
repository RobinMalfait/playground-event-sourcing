<?php namespace KBC\Storages;

use Rhumsaa\Uuid\Console\Exception;

class JsonDatabase
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function insert($data)
    {
        $rows = $this->all();
        $rows[] = $data;
        $this->writeContents($rows);
    }

    public function update($id, callable $callback)
    {
        $rows = $this->all();

        foreach ($rows as &$row) {
            if ($row['id'] == $id) {
                $row = $callback($row);
            }
        }
        $this->writeContents($rows);
    }

    public function find($id)
    {
        $rows = $this->all();
        foreach ($rows as &$row) {
            if ($row['id'] == $id) {
                return $row;
            }
        }

        throw new Exception('Record not found.');
    }

    public function delete($id)
    {
        $rows = array_filter($this->all(), function ($row) use ($id) {
            return $row['id'] != $id;
        });

        $this->writeContents($rows);
    }

    public function all()
    {
        return json_decode(file_get_contents($this->file), true);
    }

    /**
     * @param $contents
     */
    private function writeContents($contents)
    {
        file_put_contents($this->file, json_encode($contents, JSON_PRETTY_PRINT));
    }
}
