<?php
declare (strict_types=1);

namespace App\Entity;

/**
 * 查询记录实体
 * Class RecordEntity
 * @package App\Entity
 */
class RecordEntity
{

    /**
     * 查询模型
     * @var string
     */
    private string $model;

    /**
     * 是否开启分页
     * @var bool
     */
    private bool $paginate = false;


    /**
     * 分页的每页大小
     * @var int
     */
    private int $limit = 15;


    /**
     * 设置原生关联查询
     * @var array
     */
    private array $with = [];

    /**
     * 设置原生count查询
     * @var array
     */
    private array $withCount = [];


    /**
     * 分页的当前页码
     * @var int
     */
    private int $page = 1;


    /**
     * 查询条件
     * @var array
     */
    private array $where = [];


    /**
     * 显示字段
     * @var array
     */
    private array $field = ['*'];

    /**
     * 排序
     * @var array
     */
    private array $order = ['rule' => 'desc', 'field' => 'id'];

    /**
     * 中间查询表
     * @var array
     */
    private array $middle = [];

    /**
     * RecordEntity constructor.
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }


    /**
     * @param string $key
     * @return array
     */
    public function getMiddle(string $key): array
    {
        return $this->middle[$key];
    }

    /**
     * @param string $key
     * @param string $localTable
     * @param string $middle
     * @param string $foreignKey
     * @param string $localKey
     * @return RecordEntity
     */
    public function setMiddle(string $key, string $localTable, string $middle, string $foreignKey, string $localKey): self
    {
        $this->middle[$key] = [
            'middle' => $middle,
            'localTable' => $localTable,
            'foreignKey' => $foreignKey,
            'localKey' => $localKey
        ];
        return $this;
    }

    /**
     * @return array
     */
    public function getField(): array
    {
        return $this->field;
    }

    /**
     * @param array $fields
     * @return RecordEntity
     */
    public function setField(array $fields): self
    {
        $this->field = $fields;
        return $this;
    }

    /**
     * @return array
     */
    public function getWhere(): array
    {
        return $this->where;
    }

    /**
     * @param array $where
     * @return RecordEntity
     */
    public function setWhere(array $where): self
    {
        $this->where = $where;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }


    /**
     * @return bool
     */
    public function isPaginate(): bool
    {
        return $this->paginate;
    }

    /**
     * @param bool $paginate
     * @return RecordEntity
     */
    public function setPaginate(bool $paginate): self
    {
        $this->paginate = $paginate;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return RecordEntity
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return RecordEntity
     */
    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return array
     */
    public function getWith(): array
    {
        return $this->with;
    }

    /**
     * @param array $with
     * @return RecordEntity
     */
    public function setWith(array $with): self
    {
        $this->with[] = $with;
        return $this;
    }

    /**
     * @return array
     */
    public function getWithCount(): array
    {
        return $this->withCount;
    }

    /**
     * @param array $withCount
     * @return RecordEntity
     */
    public function setWithCount(array $withCount): self
    {
        $this->withCount[] = $withCount;
        return $this;
    }


    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }

    /**
     * @param string $field
     * @param string $rule
     * @return RecordEntity
     */
    public function setOrder(string $field, string $rule = 'desc'): self
    {
        if (empty($field) || empty($rule)) {
            return $this;
        }

        $this->order = ['field' => $field, 'rule' => $rule];
        return $this;
    }
}