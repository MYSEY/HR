<?php

namespace App\Repositories\Admin;

use App\Models\Bank;
use App\Repositories\BaseRepository;

/**
 * Class BankRepository
 * @package App\Repositories\V1\Bank
 * @version July 20, 2020, 3:07 am UTC
*/

class BankRepositoryEloquent extends BaseRepository
{
    /**
    * @var array
    */
    protected $fieldSearchable = [
        'id',
        'bank_name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
    * Configure the Model
    **/
    public function model()
    {
        return Bank::class;
    }
    public function bankRepoUpdateOrCreate($entry, $request){
        $oldData = $this->model->select('id')->where('member_id', $entry->id)->get();
        foreach($oldData as $key => $item) {
            if(!in_array($item->id, $request->bank_id ?? [])) {
                $item->forceDelete();
            }
        }
        if($request->bank_name){
            $bankIds = [];
            foreach($request->bank_name as $key => $item){

                $bank = $this->model->updateOrCreate(['id' => $request->bank_id[$key] ?? '',], 
                [
                    'member_id' => $entry->id,
                    'bank_name' => $request->bank_name[$key] ?? '',
                    'account_name' => $request->account_name[$key] ?? '',
                    'account_number' => $request->account_number[$key] ?? '',
                    'type' => 'Member',
                ]);
                $bankIds[] = $bank->id;
            }
        }
    }
}
