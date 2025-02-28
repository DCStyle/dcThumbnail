<?php

namespace DC\Thumbnail\Option;

use XF\Option\AbstractOption;

class Forum extends AbstractOption
{
	public static function renderSelect(\XF\Entity\Option $option, array $htmlParams)
	{
		$data = static::getSelectData($option, $htmlParams);

		return static::getTemplater()->formSelectRow(
			$data['controlOptions'], $data['choices'], $data['rowOptions']
		);
	}

	public static function renderSelectMultiple(\XF\Entity\Option $option, array $htmlParams)
	{
		$data = static::getSelectData($option, $htmlParams);
		$data['controlOptions']['multiple'] = true;
		$data['controlOptions']['size'] = 8;

		return static::getTemplater()->formSelectRow(
			$data['controlOptions'], $data['choices'], $data['rowOptions']
		);
	}

	protected static function getSelectData(\XF\Entity\Option $option, array $htmlParams)
	{
		/** @var \XF\Repository\Node $nodeRepo */
		$nodeRepo = \XF::repository('XF:Node');

		$choices = $nodeRepo->getNodeOptionsData(true, 'Forum', 'option');
		$choices = array_map(function($v) {
			$v['label'] = \XF::escapeString($v['label']);
			return $v;
		}, $choices);

		array_unshift($choices , [
			'value' => -1,
			'label' => \XF::escapeString(\XF::phrase('all'))
		]);

		return [
			'choices' => $choices,
			'controlOptions' => static::getControlOptions($option, $htmlParams),
			'rowOptions' => static::getRowOptions($option, $htmlParams)
		];
	}
}