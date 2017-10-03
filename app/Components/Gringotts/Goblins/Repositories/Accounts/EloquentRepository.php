<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts;

use App\Components\Gringotts\Goblins\Entities\Account\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Entities\Account\Term\Contracts\TermContract;
use App\Components\Gringotts\Goblins\Models\Account\AccountModel;
use App\Components\Gringotts\Goblins\Models\Account\Term\TermModel;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract;
use App\Helpers\Entities\Composable;
use App\Helpers\Models\Contracts\Model;
use Illuminate\Support\Collection;

class EloquentRepository implements RepositoryContract
{

    /**
     * @var Model
     */
    private $accountModel;

    /**
     * @var Model
     */
    private $termModel;

    /**
     * @var string
     */
    private $accountEntity = AccountContract::class;

    /**
     * @var string
     */
    private $termEntity    = TermContract::class;


    public function __construct(AccountModel $accountModel, TermModel $termModel)
    {
        $this->accountModel  = $accountModel;
        $this->termModel     = $termModel;
    }

    /**
     * @return void
     */
    private function resetModel(): void
    {
        $this->accountModel = $this->accountModel->scratch();
        $this->termModel    = $this->termModel->scratch();
    }

    /**
     * @param array $input
     * @return AccountContract
     * @throws \Exception
     */
    private function presentAsEntity(array $input): AccountContract
    {
        /** @var AccountContract $accountEntity */
        $accountEntity = app()->make($this->accountEntity);

        if (!$accountEntity instanceof Composable) {
            throw new \Exception("Entity should be an instance of Composable");
        }

        $accountEntity->compose($input);

        try {
            $termModel = $this->termModel->where('account_id', '=', $accountEntity->getID())->getOne();

            /** @var TermContract $termEntity */
            $termEntity = app()->make($this->termEntity);

            if (!$termEntity instanceof Composable) {
                throw new \Exception("Entity should be an instance of Composable");
            }

            $termEntity->compose($termModel->presentAsArray());

            $accountEntity->setTerm($termEntity);
            $termEntity->setAccount($accountEntity);

        } catch (\Exception $ex) {}

        $this->resetModel();

        return $accountEntity;
    }

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function find(int $id): AccountContract
    {
        $result = $this->accountModel->find($id);

        return $this->presentAsEntity($result->presentAsArray());
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        collect($filter)->each(function(array $params, string $field) {
            $this->accountModel->where($field, array_get($params, 'operator', '='), array_get($params, 'value'));
        });

        return $this->accountModel->getAll()->map(function(Model $item) {
            return $this->presentAsEntity($item->presentAsArray());
        });
    }

    /**
     * @param array $input
     * @return AccountContract
     */
    public function create(array $input): AccountContract
    {
        $item = $this->accountModel->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @param array $input
     * @return AccountContract
     */
    public function update(int $id, array $input): AccountContract
    {
        $item = $this->accountModel->find($id)->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->accountModel->find($id)->performDelete();
    }

    /**
     * @param AccountContract $account
     * @param array $input
     * @return AccountContract
     */
    public function createTerm(AccountContract $account, array $input): AccountContract
    {
        $input = array_merge($input, ['account_id' => $account->getID()]);

        $this->termModel->fill($input)->performSave();

        return $this->find($account->getID());
    }

    /**
     * @param TermContract    $term
     * @param array $input
     * @return AccountContract
     */
    public function updateTerm(TermContract $term, array $input): AccountContract
    {
        $this->termModel = $this->termModel->find($term->getID());
        $this->termModel->fill($input)->performSave();

        return $this->find($term->getAccount()->getID());
    }

    /**
     * @param TermContract    $term
     * @return bool
     */
    public function deleteTerm(TermContract $term): bool
    {
        $this->termModel = $this->termModel->find($term->getID());

        return $this->termModel->performDelete();
    }

}