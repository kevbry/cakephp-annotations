<?php

/**
 * Required methods for a stage-filterable annotation
 *
 * @author kevbry
 */
interface ComponentCallbacksFilterableAnnotation
{
	public function runForStage($stage);
}
