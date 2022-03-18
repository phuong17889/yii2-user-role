<?php
/**
 * Created by phuong17889.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    27/02/2016
 * @time    12:15 SA
 */

namespace phuong17889\role\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RoleSearch represents the model behind the search form about `phuong17889\role\models\Role`.
 */
class RoleSearch extends Role
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id'],
                'integer',
            ],
            [
                [
                    'name',
                    'permissions',
                    'is_backend_login',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Role::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_backend_login' => $this->is_backend_login,
        ]);
        $query->andFilterWhere([
            'like',
            'name',
            $this->name,
        ])->andFilterWhere([
            'like',
            'permissions',
            $this->permissions,
        ]);
        return $dataProvider;
    }
}
