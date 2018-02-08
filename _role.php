<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Наименование программного модуля</th>
                                                    <th>Просмотр</th>
                                                    <th>Редактирование</th>
                                                    <th>Удаление</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            <tr>
                                                <td>Администрирование</td>
                                                <td class="text-center"><input type="checkbox" name="adminView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['admin'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="adminEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['admin'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="adminRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['admin'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>Организационно-мобилизационное управление</td>
                                                <td class="text-center"><input type="checkbox" name="omuView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['omu'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="omuEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['omu'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="omuRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['omu'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>Кадры</td>
                                                <td class="text-center"><input type="checkbox" name="kadrView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['kadr'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="kadrEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['kadr'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="kadrRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['kadr'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>Телефонный справочник</td>
                                                <td class="text-center"><input type="checkbox" name="telephoneView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['telephone'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="telephoneEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['telephone'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="telephoneRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['telephone'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td><s>ЗГТ</s></td>
                                                <td class="text-center"><input type="checkbox" name="zgtView" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="zgtEdit" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="zgtRemove" value="1" disabled></td>
                                            </tr>
                                            <tr>
                                                <td>Входящие документы</td>
                                                <td class="text-center"><input type="checkbox" name="incomingView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['incoming'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="incomingEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['incoming'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="incomingRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['incoming'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td><s>Контроль исполнения документов</s></td>
                                                <td class="text-center"><input type="checkbox" name="controlView" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="controlEdit" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="controlRemove" value="1" disabled></td>
                                            </tr>
                                            <tr>
                                                <td><s>Исходящие документы</s></td>
                                                <td class="text-center"><input type="checkbox" name="outgoingView" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="outgoingEdit" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="outgoingRemove" value="1" disabled></td>
                                            </tr>
                                        </tbody>
                                        </table>