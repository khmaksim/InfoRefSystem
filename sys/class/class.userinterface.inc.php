<?php

class RoleInterface extends DatabaseConnect 
{
	public function __construct($dbo=NULL)
	{
		parent::__construct($dbo);
	}

	private function _loadData($id=NULL)
	{
		$sql = "SELECT * FROM public.user";
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

	private function _createObj()
	{
		$arr = $this->_loadData(NULL);
		$objects = array();
		foreach ($arr as $obj) {
			try {
				array_push($objects, new Role($obj));
			}
			catch (Exception $e) {
				die ($e->getMessage());
			}
		}
		return $objects;
	}

	public function display()
	{		
		$html = '
			<thead>
				<tr>
					<th class="col-xs-1">№</th>
					<th>Наименование</th>
					<th class="col-xs-1 text-center">Редактировать</th>
					<th class="col-xs-1 text-center">Удалить</th>
				</tr>
			</thead>
			<tbody id="items">
			';
		$objects = $this->_createObj();
		$count = 1;
		foreach ($objects as $obj) {
			$html .= '<tr>
							<td>' . $count++ . '</td>
                            <td>' . $obj->getName() . '</td>
                            <td class="col-xs-1 text-center"><a href="./objectskii_edit.php?action=edit&id='. $object->getId() .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $object->getId() .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>';
        }
        $html .= '</tbody>';
		return $html;
	}

	public function displayById($id=NULL)
	{
		if (empty($id) || $id == NULL)
			$obj = new Role();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$obj = $this->_loadById($id);
		}
		
		return '
			<div class="form-group">
				<label for="inputName">Наименование</label>
				<input type="text" name="name" class="form-control" id="inputName" placeholder="Наименование" value="' . $obj->getName() . '" required autofocus>
			</div>
		';
	}

	public function _loadByid($id)
	{
		if (empty($id))
			return NULL;

		$object = $this->_loadData($id);

		if (isset($objectkii[0])) {
			return new ObjectKii($objectkii[0]);
		}
		else
			return NULL;
	}

	public function processForm()
	{
		$name = htmlentities($_POST['name'], ENT_QUOTES);

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO access_right.role (name) VALUES (:name) RETURNING id";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE access_right.role SET name=:name WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
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
		if (empty($id))
			return NULL; 

		$id = preg_replace('/[^0-9]/', '', $id);

		$sql = "DELETE FROM access_right.role WHERE id=:id";
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			header("Location: {$_SERVER['HTTP_REFERER']}");
			return;
		} 
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}

?>


 <!-- // Роль пользователя по его ID
    function getRoleById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.role WHERE id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Роль есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    } -->

    <!-- // Роль пользователя по его ID
    function getRoleTitleById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT title FROM public.role WHERE id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Роль есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0]['title'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    } -->

    <!-- function getRoleUserTitleById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $arUser = array();
            $sql = "SELECT title FROM public.user WHERE role_id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Пользователь есть
            if ($res->rowCount() != 0) {
                foreach ($res as $user) {
                    $arUser[] = $user['title'];
                }
            }
            return $arUser;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    } -->

<!--      // Права доступа к ПМ по ID пользователя
    function getAccessRightById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.access_right WHERE user_id = " . intval($id);
            $res = $dbconn->query($sql);
            // Права доступа есть есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    } -->

    <!-- // Роль пользователя по его ID
    function getAccessTypeById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.taccesstype WHERE id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Роль есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    } -->