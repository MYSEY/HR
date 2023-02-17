<?php

namespace App\Repositories\Admin;

use App\Models\Certificate;
use App\Repositories\BaseRepository;

/**
 * Class BankRepository
 * @package App\Repositories\V1\Bank
 * @version July 20, 2020, 3:07 am UTC
 */

class CertificateRepositoryEloquent extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'title'
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
        return Certificate::class;
    }
    public function certificateRepoUpdateOrCreate($entry, $request)
    {
        // dd($request->attachment_certi);
        $oldData = $this->model->select('id')->where('customer_id', $entry->id)->get();
        foreach ($oldData as $key => $item) {
            if (!in_array($item->id, $request->certificate_id ?? [])) {
                $item->forceDelete();
            }
        }
        if ($request->title_certi) {
            $certificateIds = [];
            foreach ($request->title_certi as $key => $item) {
                // if ($request->hasFile('attachment_certi[' . $key . ']')) {
                $certificate = $this->model->updateOrCreate(
                    ['id' => $request->certificate_id[$key] ?? ''],
                    [
                        'customer_id' => $entry->id,
                        'title' => $request->title_certi[$key] ?? '',
                        'description' => $request->description_certi[$key] ?? '',
                        'attachment' => $request->file('attachment_certi[' . $key . ']') ?? ''
                    ]
                );
                $certificateIds[] = $certificate->id;
                // } else {
                //     $certificate = $this->model->updateOrCreate(
                //         ['id' => $request->certificate_id[$key] ?? ''],
                //         [
                //             'customer_id' => $entry->id,
                //             'title' => $request->title_certi[$key] ?? '',
                //             'description' => $request->description_certi[$key] ?? ''
                //         ]
                //     );
                //     $certificateIds[] = $certificate->id;
                // }
            }
        }
    }
}
