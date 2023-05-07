<?php

namespace App\Providers;

use App\Enum\TransactionType;
use GraphQL\Type\Definition\EnumType;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Schema\TypeRegistry;

class GraphQLServiceProvider extends ServiceProvider
{
    public function boot(TypeRegistry $typeRegistry): void
    {
        $transactionTypeEnum = new EnumType([
            'name' => 'TransactionType',
            'description' => 'Transaction type enum',
            'values' => array_reduce(
                array_map(
                    fn (TransactionType $value) => [
                        $value->name => [
                            'value' => $value->value,
                        ],
                    ],
                    TransactionType::cases()
                ),
                fn ($carry, $item) => array_merge($carry, $item),
                []
            ),
        ]);

        $typeRegistry->register($transactionTypeEnum);
    }
}
