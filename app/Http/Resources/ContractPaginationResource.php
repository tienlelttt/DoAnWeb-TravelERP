<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContractPaginationResource extends ResourceCollection
{
    /**
     * Chuẩn hóa định dạng phân trang theo hợp đồng API đang dùng.
     */
    public function toArray($request)
    {
        return [
            'content' => $this->collection,
            'pageable' => [
                'pageNumber' => $this->resource->currentPage() - 1,
                'pageSize' => $this->resource->perPage(),
                'sort' => [
                    'empty' => true,
                    'sorted' => false,
                    'unsorted' => true,
                ],
                'offset' => ($this->resource->currentPage() - 1) * $this->resource->perPage(),
                'paged' => true,
                'unpaged' => false,
            ],
            'totalElements' => $this->resource->total(),
            'totalPages' => $this->resource->lastPage(),
            'last' => $this->resource->currentPage() === $this->resource->lastPage(),
            'size' => $this->resource->perPage(),
            'number' => $this->resource->currentPage() - 1,
            'sort' => [
                'empty' => true,
                'sorted' => false,
                'unsorted' => true,
            ],
            'numberOfElements' => $this->resource->count(),
            'first' => $this->resource->currentPage() === 1,
            'empty' => $this->resource->isEmpty(),
        ];
    }
}
