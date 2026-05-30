<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SpringPaginationResource extends ResourceCollection
{
    /**
     * Chuyển đổi dữ liệu phân trang thành mảng.
     * Chuyển đổi định dạng phân trang của Laravel sang chuẩn Spring Boot.
     * Không làm hỏng Frontend React vì cấu trúc JSON giống hệt cũ.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'content' => $this->collection,
            'pageable' => [
                'pageNumber' => $this->resource->currentPage() - 1, // Spring Boot tính page từ 0
                'pageSize' => $this->resource->perPage(),
                'sort' => [
                    'empty' => true,
                    'sorted' => false,
                    'unsorted' => true
                ],
                'offset' => ($this->resource->currentPage() - 1) * $this->resource->perPage(),
                'unpaged' => false,
                'paged' => true
            ],
            'last' => $this->resource->currentPage() === $this->resource->lastPage(),
            'totalPages' => $this->resource->lastPage(),
            'totalElements' => $this->resource->total(),
            'size' => $this->resource->perPage(),
            'number' => $this->resource->currentPage() - 1, // Spring Boot tính page từ 0
            'sort' => [
                'empty' => true,
                'sorted' => false,
                'unsorted' => true
            ],
            'first' => $this->resource->currentPage() === 1,
            'numberOfElements' => $this->resource->count(),
            'empty' => $this->resource->isEmpty(),
        ];
    }
}
