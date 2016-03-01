<?php
/**
 * This file is part of the Mesour DataGrid (http://grid.mesour.com)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\DataGrid\Column;

use Mesour;
use Mesour\Table;


/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
abstract class BaseColumn extends Table\Column implements IColumn
{

    /** @var Mesour\Components\Utils\Html */
    private $filterResetButton;

    private $disabled = FALSE;

    public function setDisabled($disabled = TRUE)
    {
        $this->disabled = (bool)$disabled;
        return $this;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function setPermission($resource = NULL, $privilege = NULL)
    {
        $this->setPermissionCheck($resource, $privilege);
        return $this;
    }

    /**
     * @param Mesour\DataGrid\Extensions\Filter\IFilter $filter
     * @internal
     */
    public function setFilterReset(Mesour\DataGrid\Extensions\Filter\IFilter $filter)
    {
        if ($filter->isInline() && !$filter->isDisabled()) {
            $this->filterResetButton = $filter->createResetButton();
            $this->filterResetButton->setText($this->getTranslator()->translate('Reset filter'));

            $this->filterResetButton->class('btn-xs', TRUE);
        }
    }

    protected function getFilterResetButton()
    {
        if ($this->filterResetButton) {
            return $this->filterResetButton;
        }
        return '';
    }

    /**
     * @param null $subControl
     * @return Mesour\UI\DataGrid
     */
    final public function getGrid($subControl = NULL)
    {
        return $this->getTable($subControl);
    }

    public function validate(array $rowData, $data = [])
    {
    }

    protected function mergeAttributes($data, array $current)
    {
        $base = self::getBodyAttributes($data, FALSE);
        if (isset($base['class']) && isset($current['class'])) {
            $base['class'] = $base['class'] . ' ' . $current['class'];
        }
        return array_merge($current, $base);
    }

}
