<?php

namespace Training\TrainingBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Engine\AuthBundle\Model\User;
use Training\TrainingBundle\Model\Answer;
use Training\TrainingBundle\Model\AnswerPeer;
use Training\TrainingBundle\Model\AnswerQuery;
use Training\TrainingBundle\Model\Question;

/**
 * @method AnswerQuery orderByAnswerId($order = Criteria::ASC) Order by the training_answer_id column
 * @method AnswerQuery orderByDateModified($order = Criteria::ASC) Order by the date_modified column
 * @method AnswerQuery orderByDateCreated($order = Criteria::ASC) Order by the date_created column
 * @method AnswerQuery orderByQuestionId($order = Criteria::ASC) Order by the training_question_id column
 * @method AnswerQuery orderByAuthUserId($order = Criteria::ASC) Order by the auth_user_id column
 *
 * @method AnswerQuery groupByAnswerId() Group by the training_answer_id column
 * @method AnswerQuery groupByDateModified() Group by the date_modified column
 * @method AnswerQuery groupByDateCreated() Group by the date_created column
 * @method AnswerQuery groupByQuestionId() Group by the training_question_id column
 * @method AnswerQuery groupByAuthUserId() Group by the auth_user_id column
 *
 * @method AnswerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AnswerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AnswerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AnswerQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method AnswerQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method AnswerQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method AnswerQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method AnswerQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method AnswerQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method Answer findOne(PropelPDO $con = null) Return the first Answer matching the query
 * @method Answer findOneOrCreate(PropelPDO $con = null) Return the first Answer matching the query, or a new Answer object populated from the query conditions when no match is found
 *
 * @method Answer findOneByDateModified(string $date_modified) Return the first Answer filtered by the date_modified column
 * @method Answer findOneByDateCreated(string $date_created) Return the first Answer filtered by the date_created column
 * @method Answer findOneByQuestionId(int $training_question_id) Return the first Answer filtered by the training_question_id column
 * @method Answer findOneByAuthUserId(int $auth_user_id) Return the first Answer filtered by the auth_user_id column
 *
 * @method array findByAnswerId(int $training_answer_id) Return Answer objects filtered by the training_answer_id column
 * @method array findByDateModified(string $date_modified) Return Answer objects filtered by the date_modified column
 * @method array findByDateCreated(string $date_created) Return Answer objects filtered by the date_created column
 * @method array findByQuestionId(int $training_question_id) Return Answer objects filtered by the training_question_id column
 * @method array findByAuthUserId(int $auth_user_id) Return Answer objects filtered by the auth_user_id column
 */
abstract class BaseAnswerQuery extends \Engine\EngineBundle\Base\EngineQuery
{
    /**
     * Initializes internal state of BaseAnswerQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Training\\TrainingBundle\\Model\\Answer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AnswerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AnswerQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AnswerQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AnswerQuery) {
            return $criteria;
        }
        $query = new AnswerQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Answer|Answer[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnswerPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AnswerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Answer A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAnswerId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Answer A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `training_answer_id`, `date_modified`, `date_created`, `training_question_id`, `auth_user_id` FROM `training_answer` WHERE `training_answer_id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Answer();
            $obj->hydrate($row);
            AnswerPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Answer|Answer[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Answer[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnswerPeer::TRAINING_ANSWER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnswerPeer::TRAINING_ANSWER_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the training_answer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnswerId(1234); // WHERE training_answer_id = 1234
     * $query->filterByAnswerId(array(12, 34)); // WHERE training_answer_id IN (12, 34)
     * $query->filterByAnswerId(array('min' => 12)); // WHERE training_answer_id >= 12
     * $query->filterByAnswerId(array('max' => 12)); // WHERE training_answer_id <= 12
     * </code>
     *
     * @param     mixed $answerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByAnswerId($answerId = null, $comparison = null)
    {
        if (is_array($answerId)) {
            $useMinMax = false;
            if (isset($answerId['min'])) {
                $this->addUsingAlias(AnswerPeer::TRAINING_ANSWER_ID, $answerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($answerId['max'])) {
                $this->addUsingAlias(AnswerPeer::TRAINING_ANSWER_ID, $answerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnswerPeer::TRAINING_ANSWER_ID, $answerId, $comparison);
    }

    /**
     * Filter the query on the date_modified column
     *
     * Example usage:
     * <code>
     * $query->filterByDateModified('2011-03-14'); // WHERE date_modified = '2011-03-14'
     * $query->filterByDateModified('now'); // WHERE date_modified = '2011-03-14'
     * $query->filterByDateModified(array('max' => 'yesterday')); // WHERE date_modified > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateModified The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByDateModified($dateModified = null, $comparison = null)
    {
        if (is_array($dateModified)) {
            $useMinMax = false;
            if (isset($dateModified['min'])) {
                $this->addUsingAlias(AnswerPeer::DATE_MODIFIED, $dateModified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateModified['max'])) {
                $this->addUsingAlias(AnswerPeer::DATE_MODIFIED, $dateModified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnswerPeer::DATE_MODIFIED, $dateModified, $comparison);
    }

    /**
     * Filter the query on the date_created column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreated('2011-03-14'); // WHERE date_created = '2011-03-14'
     * $query->filterByDateCreated('now'); // WHERE date_created = '2011-03-14'
     * $query->filterByDateCreated(array('max' => 'yesterday')); // WHERE date_created > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateCreated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByDateCreated($dateCreated = null, $comparison = null)
    {
        if (is_array($dateCreated)) {
            $useMinMax = false;
            if (isset($dateCreated['min'])) {
                $this->addUsingAlias(AnswerPeer::DATE_CREATED, $dateCreated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreated['max'])) {
                $this->addUsingAlias(AnswerPeer::DATE_CREATED, $dateCreated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnswerPeer::DATE_CREATED, $dateCreated, $comparison);
    }

    /**
     * Filter the query on the training_question_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestionId(1234); // WHERE training_question_id = 1234
     * $query->filterByQuestionId(array(12, 34)); // WHERE training_question_id IN (12, 34)
     * $query->filterByQuestionId(array('min' => 12)); // WHERE training_question_id >= 12
     * $query->filterByQuestionId(array('max' => 12)); // WHERE training_question_id <= 12
     * </code>
     *
     * @see       filterByQuestion()
     *
     * @param     mixed $questionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByQuestionId($questionId = null, $comparison = null)
    {
        if (is_array($questionId)) {
            $useMinMax = false;
            if (isset($questionId['min'])) {
                $this->addUsingAlias(AnswerPeer::TRAINING_QUESTION_ID, $questionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionId['max'])) {
                $this->addUsingAlias(AnswerPeer::TRAINING_QUESTION_ID, $questionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnswerPeer::TRAINING_QUESTION_ID, $questionId, $comparison);
    }

    /**
     * Filter the query on the auth_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthUserId(1234); // WHERE auth_user_id = 1234
     * $query->filterByAuthUserId(array(12, 34)); // WHERE auth_user_id IN (12, 34)
     * $query->filterByAuthUserId(array('min' => 12)); // WHERE auth_user_id >= 12
     * $query->filterByAuthUserId(array('max' => 12)); // WHERE auth_user_id <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $authUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function filterByAuthUserId($authUserId = null, $comparison = null)
    {
        if (is_array($authUserId)) {
            $useMinMax = false;
            if (isset($authUserId['min'])) {
                $this->addUsingAlias(AnswerPeer::AUTH_USER_ID, $authUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($authUserId['max'])) {
                $this->addUsingAlias(AnswerPeer::AUTH_USER_ID, $authUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnswerPeer::AUTH_USER_ID, $authUserId, $comparison);
    }

    /**
     * Filter the query by a related Question object
     *
     * @param   Question|PropelObjectCollection $question The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnswerQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuestion($question, $comparison = null)
    {
        if ($question instanceof Question) {
            return $this
                ->addUsingAlias(AnswerPeer::TRAINING_QUESTION_ID, $question->getQuestionId(), $comparison);
        } elseif ($question instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnswerPeer::TRAINING_QUESTION_ID, $question->toKeyValue('PrimaryKey', 'QuestionId'), $comparison);
        } else {
            throw new PropelException('filterByQuestion() only accepts arguments of type Question or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Question relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function joinQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Question');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Question');
        }

        return $this;
    }

    /**
     * Use the Question relation Question object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Training\TrainingBundle\Model\QuestionQuery A secondary query class using the current class as primary query
     */
    public function useQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuestion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Question', '\Training\TrainingBundle\Model\QuestionQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnswerQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(AnswerPeer::AUTH_USER_ID, $user->getUserId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnswerPeer::AUTH_USER_ID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Engine\AuthBundle\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Engine\AuthBundle\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Answer $answer Object to remove from the list of results
     *
     * @return AnswerQuery The current query, for fluid interface
     */
    public function prune($answer = null)
    {
        if ($answer) {
            $this->addUsingAlias(AnswerPeer::TRAINING_ANSWER_ID, $answer->getAnswerId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
