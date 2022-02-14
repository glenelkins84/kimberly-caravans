<?php

namespace App\Repositories;

use App\Models\Branch;

/**
 * Class BranchRepository
 * @package App\Repositories
 */
class BranchRepository extends BaseRepository
{

    /**
     * @param string $branchName
     * @return Branch
     */
    public function getByNameOrCreate(string $branchName) : Branch
    {


        /** @var Branch $branch */
        if(!$branch = Branch::where('name',$branchName)->first()){

            // create new branch
            $branch = (new Branch())->setName($branchName);
            $branch->save();
        }

        return $branch;
    }

}