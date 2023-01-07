<?php

namespace App\Contracts;

interface DataServiceContract
{
    /**
     * Create data
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);


    /**
     * Delete data
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);


    /**
     * Update data
     *
     * @param array $data
     * @return mixed
     */
    public function update(array $data);

    /**
     * Get all data or by id
     *
     * @param int|null $id
     * @return mixed
     */
    public function get(?int $id);
}
