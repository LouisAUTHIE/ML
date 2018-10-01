<?php

namespace Rubix\Tests;

use Rubix\ML\Estimator;
use Rubix\ML\Persistable;
use Rubix\ML\MetaEstimator;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Classifiers\DummyClassifier;
use PHPUnit\Framework\TestCase;

class PersistentModelTest extends TestCase
{
    protected $estimator;

    protected $persister;

    protected $model;

    public function setUp()
    {
        $this->estimator = new DummyClassifier();

        $this->persister = $this->createMock(Filesystem::class);

        $this->model = new PersistentModel($this->estimator, $this->persister);
    }

    public function test_build_meta_estimator()
    {
        $this->assertInstanceOf(PersistentModel::class, $this->model);
        $this->assertInstanceOf(MetaEstimator::class, $this->model);
        $this->assertInstanceOf(Estimator::class, $this->model);
    }
}
