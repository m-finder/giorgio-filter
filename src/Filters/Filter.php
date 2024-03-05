<?php

namespace GiorgioFilter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Filter
{
    public Builder $builder;

    /**
     * scope
     */
    public function scopeFilter($query, array $validated): Builder
    {
        $this->builder = $query;

        return $this->apply($validated);
    }

    protected function apply(array $validated): Builder
    {
        // 过滤请求参数，保留请求值为 0 和 false 的查询条件
        $validated = array_filter($validated, function ($val) {
            return ! ($val === '' || is_null($val));
        });

        foreach ($validated as $name => $value) {
            $data = [$value];
            $method = Str::camel($name).'Filter';
            info($method);

            if ($this->callable($data, $name)) {
                info('callable', [
                    'name' => $name,
                    'data' => $data,
                ]);
                if (method_exists($this, $method)) {
                    info('method_exists', [
                        'method' => $method,
                    ]);
                    call_user_func_array([$this, $method], $data);
                } else {
                    info('magicCall', [
                        'method' => $method,
                    ]);
                    $this->magicCall($name, $data);
                }
            }
        }

        return $this->builder;
    }

    /**
     * 伪魔术方法，构造 builder 查询条件
     */
    public function magicCall($name, $argument): Builder
    {
        return $this->builder->where($name, '=', $argument);
    }

    /**
     * 检查方法是否可用
     */
    protected function callable($data, $name): bool
    {
        return ! is_null($data) || in_array($name, array_merge($this->fillable ?? [], ['id', 'created_at', 'updated_at', 'start_date', 'end_date']));
    }

    /**
     * 创建日期
     */
    protected function startDateFilter($date): Builder
    {
        $start = $date.' 00:00:00';

        return $this->builder->where('created_at', '>=', $start);
    }

    /**
     * 创建日期
     */
    protected function endDateFilter($date): Builder
    {
        $end = $date.' 23:59:59';

        return $this->builder->where('created_at', '<=', $end);
    }
}
