<?php
declare (strict_types=1);

namespace App\Service\Admin;


use App\Entity\RecordEntity;
use Hyperf\Database\Query\JoinClause;

abstract class BaseService
{
    /**
     * 快速查询记录
     * @param RecordEntity $recordEntity
     * @return
     */
    protected function getRecords(RecordEntity $recordEntity)
    {

        $query = $recordEntity->getModel()::query();
        $with = $recordEntity->getWith();
        $where = $recordEntity->getWhere();  // equal_user = xxx
        $order = $recordEntity->getOrder();
        $field = $recordEntity->getField();
        $withCount = $recordEntity->getWithCount();
        $fieldRefactor = false;

        //将where拆分
        foreach ($where as $key => $val) {
            if (is_scalar($val)) {
                $val = urldecode($val);
            }
            $key = urldecode($key);
            $args = explode('-', $key);
            if ($val === '') {
                continue;
            }
            switch ($args[0]) {
                case "equal":
                    $query = $query->where($args[1], $val);
                    break;
                case "betweenStart":
                    $query = $query->where($args[1], ">=", $val);
                    break;
                case "betweenEnd":
                    $query = $query->where($args[1], "<=", $val);
                    break;
                case "search":
                    $query = $query->where($args[1], "like", '%' . $val . '%');
                    break;
                case "middle":
                    //这里将完全改变查询方式
                    $middle = $recordEntity->getMiddle($args[1]);
                    $val = explode(",", $val);
                    $query = $query->join($middle['middle'], function (JoinClause $join) use ($middle, $val) {
                        $join->on("{$middle['localTable']}.id", '=', "{$middle['middle']}.{$middle['localKey']}")->whereIn("{$middle['middle']}.{$middle['foreignKey']}", $val);
                    });
                    //重构查询字段
                    if (!$fieldRefactor) {
                        foreach ($field as $index => $value) {
                            $field[$index] = $middle['localTable'] . '.' . $value;
                        }
                        $fieldRefactor = true;
                    }
                    break;
            }
        }

        foreach ($with as $w) {
            $query = $query->with($w);
        }

        foreach ($withCount as $wc) {
            $query = $query->withCount($wc);
        }

        $query = $query->orderBy($order['field'], $order['rule'])->distinct();

        if ($recordEntity->isPaginate()) {
            return $query->paginate($recordEntity->getLimit(), $field, '', $recordEntity->getPage());
        }

        return $query->get();
    }
}