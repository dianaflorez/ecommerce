<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

use Yii;

/**
 * InvoiceSearch represents the model behind the search form of `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    public $userName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['total'], 'number'],
            [['type', 'status', 'created_at', 'userName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Invoice::find()->joinWith('user');

        // add conditions that should always apply here

        // 🔐 FILTRO POR ROL
        $user = Yii::$app->user->identity;

        if ($user->role === Usuario::ROLE_DISTRIBUTOR) {
            $query->andWhere(['user_id' => $user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->sort->attributes['userName'] = [
            'asc' => ['usuario.lastname' => SORT_ASC],
            'desc' => ['usuario.lastname' => SORT_DESC],
        ];
        

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total' => $this->total,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'type', $this->type])
            ->andFilterWhere(['ilike', 'status', $this->status]);

        $query->andFilterWhere([
            'or',
            ['ilike', 'usuario.name', $this->userName],
            ['ilike', 'usuario.lastname', $this->userName],
        ]);

        return $dataProvider;
    }
}
