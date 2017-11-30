<?php

class EnterpriseInterface extends BaseInterface 
{
	protected function _loadData($id=NULL)
	{
		$sql = "SELECT * FROM enterprise";
		if (!empty($id)) {
			$sql .= " WHERE id=:id LIMIT 1";
		} 
		try	{
			$stmt = $this->db->prepare($sql);
			if (!empty($id)) {
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			}
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $results;
		}
		catch (Exception $e) {
			die ($e->getMessage());
		}
	}

	public function display()
	{		
		$html = '
			<thead>
				<tr>
					<th class="col-xs-1">№</th>
					<th>Название</th>
					<th>Место дислокации</th>
					<th>Руководитель</th>
					<th>Должность</th>
					<th class="col-xs-1 text-center">Редактировать</th>
					<th class="col-xs-1 text-center">Удалить</th>
				</tr>
			</thead>
			<tbody id="items">
			';
		$objects = $this->_createObject("Enterprise");
		$count = 1;
		foreach ($objects as $obj) {
			$html .= '<tr>
							<td>' . $count++ . '</td>
                            <td>' . $obj->name . '</td>
                            <td>' . $obj->location . '</td>
                            <td>' . $obj->head . '</td>
                            <td>' . $obj->post . '</td>
                            <td class="col-xs-1 text-center"><a href="./enterprise_edit.php?action=edit&id='. $obj->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $obj->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>';
        }
        $html .= '</tbody>';
		return $html;
	}

	public function displayById($id=NULL)
	{
		$image = '';
		if (empty($id) || $id == NULL)
			$enterprise = new Enterprise();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$enterprise = $this->_loadById("Enterprise", $id);
		}
		
		return '
			<div class="form-group">
				<label for="inputName">Наименование</label>
				<input type="text" name="name" class="form-control" id="inputName" placeholder="Наименование" value="' . $enterprise->name . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="inputLocation">Место дислокации</label>
				<input type="text" name="location" class="form-control" id="inputLocation" placeholder="Место дислокации" value="' . $enterprise->location . '">
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="inputHead">Руководитель</label>
						<input type="text" name="head" class="form-control" id="inputHead" placeholder="Руководитель" value="' . $enterprise->head . '">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label for="inputPost">Должность</label>
						<input type="text" name="post" class="form-control" id="inputPost" placeholder="Должность" value="' . $enterprise->post . '">
					</div>
				</div>
			</div>';
	}

	public function processForm()
	{
		$name = htmlentities($_POST['name'], ENT_QUOTES);
		$location = htmlentities($_POST['location'], ENT_QUOTES);
		$head = htmlentities($_POST['head'], ENT_QUOTES);
		$post = htmlentities($_POST['post'], ENT_QUOTES);
		$id = NULL;

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO public.enterprise (name, location, head, post) VALUES (:name, :location, :head, :post)";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE public.enterprise SET name=:name, location=:location, head=:head, post=:post WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":location", $location, PDO::PARAM_STR);
			$stmt->bindParam(":head", $head, PDO::PARAM_STR);
			$stmt->bindParam(":post", $post, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
            return TRUE;
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function delete($id)
	{
		if (empty($id)) { 
			return NULL; 
		}
		$id = preg_replace('/[^0-9]/', '', $id);
		$object = $this->_loadById("Enterprise", $id);

		$sql = "DELETE FROM enterprise WHERE id=:id";
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $object->image_file_name))
                unlink($_SERVER['DOCUMENT_ROOT'] . $object->image_file_name);

			header("Location: {$_SERVER['HTTP_REFERER']}");
			return;
		} 
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}

?>