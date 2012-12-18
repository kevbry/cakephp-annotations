<?php
/**
 * Base class for annotation filtering
 *
 * @author kevbry
 */
interface AnnotationFilter
{
	/**
	 * Filter the list of annotations, returning an array of thos which match
	 * @param array $annotations
	 */
	public function apply($annotations);
}

