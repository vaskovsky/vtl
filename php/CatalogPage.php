<?php
/*!
 * Copyright © 2017 Alexey Vaskovsky.
 *
 * This file is part of VTL.
 *
 * VTL is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 *
 * VTL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with VTL. If not, see <http://www.gnu.org/licenses/>.
 * @file
 */
namespace VTL;
/**
 * Catalog page pattern.
 *
 * @class VTL::CatalogPage
 * @extends VTL::AbstractPage
 *
 * @author Alexey Vaskovsky
 */
/**
 * Returns an associative array that contains an initial model data; never null.
 *
 * @protected @fn create()
 * @memberof VTL::CatalogPage
 */
/**
 * Sanitizes a model data.
 *
 * @protected @fn sanitize($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a model data; never null.
 *
 * @return an associative array that contains the sanitized data; never null.
 */
/**
 * Validates a model data to update model.
 *
 * @protected @fn validateUpdate($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a sanitized model data; never null.
 *
 * @return a string that contains a validation error or nothing if the model is
 *         valid.
 */
/**
 * Validates a model data to insert model.
 *
 * The default implementation uses `$this->validateUpdate($x)`.
 *
 * @protected @fn validateInsert($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a sanitized model data; never null.
 *
 * @return a string that contains a validation error or nothing if the model is
 *         valid.
 */
/**
 * Validates primary key in a model.
 *
 * @protected @fn validateKey($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a sanitized model data; never null.
 *
 * @return a string that contains a validation error
 *         or nothing if the model is valid.
 */
/**
 * Returns an iterable list of objects that contains the selected models; never
 * null.
 *
 * @protected @fn select($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a sanitized model data; never null.
 */
/**
 * Returns an object that contains the model data or null if the model with the
 * specified key is not found.
 *
 * @protected @fn get($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a sanitized model data with the valid
 *        	primary key; never null.
 */
/**
 * Inserts a new model in the database.
 *
 * @protected @fn insert($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a valid model data; never null.
 */
/**
 * Updates a model in the database.
 *
 * @protected @fn update($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a valid model data; never null.
 */
/**
 * Deletes a model from the database.
 *
 * @protected @fn delete($x)
 * @memberof VTL::CatalogPage
 *
 * @param object $x
 *        	is an object that contains a sanitized model data with the valid
 *        	primary key; never null.
 */
/**
 * The SELECT action.
 *
 * @public @fn doSelect()
 * @memberof VTL::CatalogPage
 *
 * @return a string; never null.
 */
/**
 * The GET action.
 *
 * @public @fn doGet()
 * @memberof VTL::CatalogPage
 *
 * @return a string; never null.
 */
/**
 * The ADD action.
 *
 * @public @fn doAdd()
 * @memberof VTL::CatalogPage
 *
 * @return a string; never null.
 */
/**
 * The INSERT action.
 *
 * @public @fn doInsert()
 * @memberof VTL::CatalogPage
 *
 * @return a string; never null.
 */
/**
 * The UPDATE action.
 *
 * @public @fn doUpdate()
 * @memberof VTL::CatalogPage
 *
 * @return a string; never null.
 */
/**
 * The DELETE action.
 *
 * @public @fn doDelete()
 * @memberof VTL::CatalogPage
 *
 * @return a string; never null.
 */
trait CatalogPage {
	abstract protected function create();
	abstract protected function sanitize($x);
	abstract protected function select($x);
	abstract protected function get($x);
	abstract protected function insert($x);
	abstract protected function update($x);
	abstract protected function delete($x);
	abstract protected function validateUpdate($x);
	protected function validateInsert($x)
	{
		return $this->validateUpdate($x);
	}
	protected function validateKey($x)
	{
		// x: -null
		if (! is_object($x)) {
			throw new \InvalidArgumentException();
		}
		//
		if (empty($x->id))
			return _("Empty ID");
	}
	public function doSelect()
	{
		//
		$req = (object) $this->sanitize((object) $_REQUEST);
		$list = $this->select($req);
		$model_name = (new \ReflectionClass($this))->getShortName();
		return $this->render(
			"{$model_name}Index",
			array(
				"request" => $req,
				"list" => $list
			));
	}
	public function doGet()
	{
		//
		$req = (object) $this->sanitize((object) $_REQUEST);
		$err = $this->validateKey($req);
		if (! empty($err))
			return $this->doSelect();
		$data = $this->get($req);
		if (empty($data))
			return $this->renderError(_("Not found"), 404);
		$model_name = (new \ReflectionClass($this))->getShortName();
		return $this->render(
			"{$model_name}Editor",
			array(
				"request" => $req,
				"model" => $data,
				"permissions" => (object) [
					"can_insert" => false,
					"can_update" => true,
					"can_delete" => true
				]
			));
	}
	public function doAdd()
	{
		//
		$req = (object) $this->sanitize((object) $_REQUEST);
		$data = (object) $this->create();
		$model_name = (new \ReflectionClass($this))->getShortName();
		return $this->render(
			"{$model_name}Editor",
			array(
				"request" => $req,
				"model" => $data,
				"permissions" => (object) [
					"can_insert" => true,
					"can_update" => false,
					"can_delete" => false
				]
			));
	}
	public function doInsert()
	{
		//
		$req = (object) $this->sanitize((object) $_REQUEST);
		$err = $this->validateInsert($req);
		if (! empty($err))
			return $this->renderError($err, 400);
		$this->insert($req);
		return $this->doSelect();
	}
	public function doUpdate()
	{
		//
		$req = (object) $this->sanitize((object) $_REQUEST);
		$err = $this->validateKey($req);
		if (! empty($err))
			return $this->renderError($err, 400);
		$err = $this->validateUpdate($req);
		if (! empty($err))
			return $this->renderError($err, 400);
		$this->update($req);
		return $this->doSelect();
	}
	public function doDelete()
	{
		//
		$req = (object) $this->sanitize((object) $_REQUEST);
		$err = $this->validateKey($req);
		if (! empty($err))
			return $this->renderError($err, 400);
		$this->delete($req);
		return $this->doSelect();
	}
}
