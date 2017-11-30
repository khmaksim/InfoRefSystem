<?php

class ScientificResearchDesignWorkInterface extends BaseInterface 
{
	protected function _loadData($id=NULL)
	{
		$sql = "SELECT * FROM scientific_research_design_work";
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
					<th>Перечень НИОКР</th>
					<th class="col-xs-1 text-center">Редактировать</th>
					<th class="col-xs-1 text-center">Удалить</th>
				</tr>
			</thead>
			<tbody id="items">
			';
		$objects = $this->_createObject("ScientificResearchDesignWork");
		$count = 1;
		foreach ($objects as $obj) {
			$html .= '<tr>
							<td>' . $count++ . '</td>
                            <td><a href="download.php?file=' . $obj->file_name . '" target="_blank">' . $obj->year . '</a></td>
                            <td class="col-xs-1 text-center"><a href="./scientificresearchdesignwork_edit.php?action=edit&id='. $obj->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
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
			$obj = new ScientificResearchDesignWork();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$obj = $this->_loadById("ScientificResearchDesignWork", $id);
		}
		
		return '
			<div class="row">
				<div class="col-md-1">
					<div class="form-group">
						<label for="inputYear">Год</label>
						<input type="text" min="2000" max="2099" name="year" class="form-control" id="inputYear" oninput="validateYear(this)" placeholder="Год" value="' . $obj->year . '" required autofocus>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="inputFile">' . ($obj->file_name  !=  '' ? '<a href="download.php?file=' . $obj->file_name . '" target="_blank">Файл</a><br />' : 'Файл') . '</label>
				<input type="file" name="document-file" id="inputFile">
				<p class="help-block">Размер файла не более 2 Мб.</p>
			</div>';
	}

	public function processForm()
	{
		$year = htmlentities($_POST['year'], ENT_QUOTES);
		$id = NULL;

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO public.scientific_research_design_work (year) VALUES (:year) RETURNING id";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE public.scientific_research_design_work SET year=:year WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":year", $year, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();

			if ($id == NULL)
				$id = $this->db->lastInsertId('scientific_research_design_work_id_seq');

           	if (sizeof($_FILES) && !$_FILES['document-file']['error'] && $_FILES['document-file']['size'] < 1024 * 2 * 1024) {
                $uploadInfo = $_FILES['document-file'];
                $fileName = $_SERVER['DOCUMENT_ROOT'] . 'uploaded_files/scientific_research_design_work/' . $id;

				switch ($uploadInfo['type']) {
                    case 'image/jpeg':
                        $fileName .= '.jpg';
                        break;
                    case 'image/png':
                        $fileName .= '.png';
                        break;
                    case 'application/msword':
                        $fileName .= '.doc';
                        break;
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        $fileName .= '.docx';
                        break;
                    case 'application/pdf':
                        $fileName .= '.pdf';
                        break;
                    default:
                        exit;
                }
                $fileName = iconv('utf-8', 'windows-1251', $fileName);
                if (!move_uploaded_file($uploadInfo['tmp_name'], $fileName))
                	echo 'Не удалось осуществить сохранение файла';

                $this->db->query("UPDATE public.scientific_research_design_work SET file_name = '" . $fileName . "' WHERE id = " . $id);
            }

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
		$object = $this->_loadById("ScientificResearchDesignWork", $id);

		$sql = "DELETE FROM scientific_research_design_work WHERE id=:id";
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