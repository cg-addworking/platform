<?php

namespace Components\User\User\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\User\User\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getAuthUserFirstName(): string
    {
        return Auth::user()->firstname ?? '';
    }

    public function getNumberOfContractToSign(string $signatory_id): int
    {
        $query = 'SELECT count(distinct "acc"."id") as "count_addworking_contract_contracts" ';
        $query .= ' FROM "public"."addworking_contract_contracts" AS "acc"';
        $query .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp"';
        $query .= ' ON "acc"."next_party_to_sign_id" = "accp"."id"';
        $query .= ' LEFT JOIN "public"."addworking_enterprise_work_fields" AS "aewf"';
        $query .= ' ON "acc"."workfield_id" = "aewf"."id"';
        $query .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp1"';
        $query .= ' ON "acc"."id" = "accp1"."contract_id"';
        $query .= ' WHERE ((("accp"."signatory_id") = \''.$signatory_id.'\'))';
        $query .= ' AND ((("accp1"."is_validator") IS FALSE))';
        $query .= ' AND ((("accp1"."signatory_id") IS NULL OR ("accp1"."signatory_id") <> \''.$signatory_id.'\'))';
        $query .= ' AND (((("acc"."state")::varchar) = \'to_sign\'))';
        $query .= ' AND ((("acc"."deleted_at") IS NULL))';
        $query .= ' ORDER BY "count_addworking_contract_contracts" DESC';

        $result = DB::select(DB::raw($query));

        return $result[0]->count_addworking_contract_contracts;
    }

    public function getContractsToSign(string $signatory_id)
    {
        $query = 'SELECT "acc"."id" AS "contract_id","acc"."valid_from" AS "contract_valid_from",';
        $query .= ' "acc"."valid_until" AS "contract_valid_until","acc"."state" AS "contract_state",';
        $query .= ' "acc"."next_party_to_sign_id" AS "contract_next_party_to_sign_id",';
        $query .= ' "aewf"."display_name" AS "work_display_name",';
        $query .= ' "accp1"."enterprise_name" AS "vendor_enterprise_name"';
        $query .= ' FROM "public"."addworking_contract_contracts" AS "acc"';
        $query .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp"';
        $query .= ' ON "acc"."next_party_to_sign_id" = "accp"."id"';
        $query .= ' LEFT JOIN "public"."addworking_enterprise_work_fields" AS "aewf"';
        $query .= ' ON "acc"."workfield_id" = "aewf"."id"';
        $query .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp1"';
        $query .= ' ON "acc"."id" = "accp1"."contract_id"';
        $query .= ' WHERE ((("accp"."signatory_id") = \''.$signatory_id.'\'))';
        $query .= ' AND ((("accp1"."is_validator") IS FALSE))';
        $query .= ' AND ((("accp1"."signatory_id") IS NULL OR ("accp1"."signatory_id") <> \''.$signatory_id.'\'))';
        $query .= ' AND (((("acc"."state")::varchar) = \'to_sign\'))';
        $query .= ' AND ((("acc"."deleted_at") IS NULL)) LIMIT 5';

        return DB::select(DB::raw($query));
    }

    public function getNumberOfContractPending(string $signatory_id): int
    {

        $query = 'SELECT count(distinct "acc"."id") as "count_addworking_contract_contracts"';
        $query .= ' FROM "public"."addworking_contract_contracts" AS "acc"';
        $query .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp1"';
        $query .= ' ON "acc"."id" = "accp1"."contract_id"';
        $query .= ' WHERE ((("accp1"."signatory_id") = \''.$signatory_id.'\'))';
        $query .= ' AND (((("acc"."state")::varchar) IN (\'in_preparation\',\'missing_documents\')))';
        $query .= ' AND ((("acc"."deleted_at") IS NULL))';
        $query .= ' ORDER BY "count_addworking_contract_contracts" DESC';

        $result = DB::select(DB::raw($query));

        return $result[0]->count_addworking_contract_contracts;
    }

    public function getContractsPending(string $signatory_id)
    {
        $query_1 = 'SELECT "acc"."id" AS "id"';
        $query_1 .= ' FROM "public"."addworking_contract_contracts" AS "acc"';
        $query_1 .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp1"';
        $query_1 .= ' ON "acc"."id" = "accp1"."contract_id"';
        $query_1 .= ' WHERE ((("accp1"."signatory_id") = \''.$signatory_id.'\'))';
        $query_1 .= ' AND ((("acc"."deleted_at") IS NULL))';
        $query_1 .= ' AND (((("acc"."state")::varchar) IN (\'in_preparation\',\'missing_documents\')))';

        $result_1 = DB::select(DB::raw($query_1));

        $count = count($result_1);

        if ($count) {
            $ids = '';
            $i = 1;
            foreach ($result_1 as $id) {
                $ids .= "'{$id->id}'";
                if ($i != $count) {
                    $ids .= ',';
                }
                $i++;
            }

            $query = 'SELECT "acc"."id" AS "contract_id","acc"."valid_from" AS "contract_valid_from",';
            $query .= ' "acc"."valid_until" AS "contract_valid_until","acc"."state" AS "contract_state",';
            $query .= ' "aewf"."display_name" AS "work_display_name",';
            $query .= ' "accp1"."enterprise_name" AS "vendor_enterprise_name"';
            $query .= ' FROM "public"."addworking_contract_contracts" AS "acc"';
            $query .= ' LEFT JOIN "public"."addworking_enterprise_work_fields" AS "aewf"';
            $query .= ' ON "acc"."workfield_id" = "aewf"."id"';
            $query .= ' LEFT JOIN "public"."addworking_contract_contract_parties" AS "accp1"';
            $query .= ' ON "acc"."id" = "accp1"."contract_id"';
            $query .= ' WHERE ((("acc"."id") IN ('.$ids.')))';
            $query .= ' AND ((("acc"."deleted_at") IS NULL))';
            $query .= ' AND ((("accp1"."enterprise_id") <> "acc"."enterprise_id"))';
            $query .= ' ORDER BY "acc"."valid_from" ASC LIMIT 5';

            return DB::select(DB::raw($query));
        } else {
            return [];
        }
    }
}
