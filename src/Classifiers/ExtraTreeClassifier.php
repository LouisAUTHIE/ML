<?php

namespace Rubix\ML\Classifiers;

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Graph\Nodes\Comparison;
use InvalidArgumentException;

/**
 * Extra Tree Classifier
 *
 * An Extremely Randomized Classification Tree that splits the training set at
 * a random point chosen among the maximum features. Extra Trees are useful in
 * Ensembles such as Random Forest or AdaBoost as the “weak” classifier or they
 * can be used on their own. The strength of Extra Trees are computational
 * efficiency as well as increasing variance of the prediction (if that is
 * desired).
 *
 * References:
 * [1] P. Geurts et al. (2005). Extremely Randomized Trees.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class ExtraTreeClassifier extends ClassificationTree
{
    /**
     * Randomized algorithm to that choses the split point with the lowest gini
     * impurity among a random selection of $maxFeatures features.
     *
     * @param  \Rubix\ML\Datasets\Labeled  $dataset
     * @return \Rubix\ML\Graph\Nodes\Comparison
     */
    protected function findBestSplit(Labeled $dataset) : Comparison
    {
        $bestGini = INF;
        $bestIndex = $bestValue = null;
        $bestGroups = [];

        $max = $dataset->numRows() - 1;

        shuffle($this->indices);

        foreach (array_slice($this->indices, 0, $this->maxFeatures) as $index) {
            $sample = $dataset->row(rand(0, $max));

            $value = $sample[$index];

            $groups = $dataset->partition($index, $value);

            $gini = $this->gini($groups);

            if ($gini < $bestGini) {
                $bestGini = $gini;
                $bestIndex = $index;
                $bestValue = $sample[$index];
                $bestGroups = $groups;
            }

            if ($gini <= $this->tolerance) {
                break 1;
            }
        }

        return new Comparison($bestIndex, $bestValue, $bestGroups, $bestGini);
    }
}
