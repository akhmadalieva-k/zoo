<?php
// print_r($data["departments"]);
?>
<p><a href="http://localhost:84">На главную</a></p>
<div class="container__main">
    <div class="container__header">
        <h1>zoopark</h1>
    </div>
    <div class="container__body">
        <div class="container__table">
            <div class="container__table__head">
                <div class="container__table__options">
                    <h1>Список всех сотрудников зооопарка 🐾</h1>
                    <div class="container__select__class">
                        <h2>выбрать параметры:</h2>
                        <form action="http://localhost:84/employees/select" method="post">
                            <div class="checkbox">
                                <label for="spec_id">вабрать специализацию:</label>
                                <select name="spec_id" id="spec_id">
                                    <option value="all">показать все</option>
                                    <option value="1">зоология</option>
                                    <option value="2">орнитология</option>
                                    <option value="3">герпетология</option>
                                    <option value="4">амфибиология</option>
                                    <option value="5">ихтиология</option>
                                    <option value="6">энтомология</option>
                                </select>
                                <input name="get_selected_spec" type="submit" value="показать">
                            </div>
                        </form>
                    </div>
                </div>
                <button onclick="openEmployeeAddModal()">➕ Добавить сотрудника</button>
            </div>
            <!-- </form> -->
            <?php
            $titles = [
                "employee_id" => "номер",
                "employee_name" => "имя",
                "specialization_name" => "специализация",
                "department_name" => "отдел",
            ]; ?>
            <table>
                <thead>
                    <tr>
                        <?php foreach ($titles as $titleKey => $titleValue): ?>
                            <th>
                                <?php echo $titleValue; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data["employees"] as $keyArr => $valueArr): ?>
                        <tr>
                            <?php //foreach ($valueArr as $key => $cell): 
                            foreach ($valueArr as $key => $cell):
                            ?>
                                <?php if ($key == "employee_id"): ?>
                                    <td> <?php $id = htmlspecialchars($cell); ?>
                                        <button onclick='openEditEmployeeModal(<?= json_encode($valueArr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                            ✏ <?= htmlspecialchars($id) ?>
                                        </button>
                                    </td>
                                <?php elseif ($key == "employee_name"): ?>
                                    <?php $nameEmployee = htmlspecialchars($cell); ?>
                                    <td>
                                        <?php echo "<a href='http://localhost:84/page/employee/$id'>$nameEmployee</a>" ?>
                                    </td>
                                <?php elseif ($key == "department_id"): ?>
                                    <?php $idDep = htmlspecialchars($cell); ?>

                                <?php elseif ($key == "department_name"): ?>
                                    <td>
                                        <?php
                                        echo "<a href='http://localhost:84/departments/department/$idDep'>$cell</a>"; ?>
                                    </td>

                                <?php else: ?>
                                    <td>
                                        <?php echo htmlspecialchars($cell); 
                                        ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="employeeAddModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeEmployeeAddModal()">&times;</span>
        <h2>добавить нового сотрудника:</h2>
        <form action="http://localhost:84/employees/add" method="post">
            <div class="form__input">
                <label for="employee_name">ФИО:</label>
                <input type="text" name="value[employee_name]" id="employee_name">
                <br>
                <label for="specialization_id">Специализация:</label>
                <select name="value[specialization_id]" id="specialization_id">
                    <option value="1">зоология</option>
                    <option value="2">орнитология</option>
                    <option value="3">герпетология</option>
                    <option value="4">амфибиология</option>
                    <option value="5">ихтиология</option>
                    <option value="6">энтомология</option>
                </select>
                <br>
                <label for="department_id">Отдел:</label>
                <select name="value[department_id]" id="department_id" required>
                <?php foreach ($data["departments"] as $emp): ?>
                    <option value="<?= htmlspecialchars($emp['department_id']) ?>">
                        <?= htmlspecialchars($emp['department_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
                <!-- <label for="department_id">Отдел:</label>
                <select name="value[department_id]" id="department_id">
                    <option value="0">Не выбран</option>
                    <option value="1">Хищные млекопитающие</option>
                    <option value="2">Травоядные млекопитающие</option>
                    <option value="3">Приматы</option>
                    <option value="4">Летающие птицы</option>
                    <option value="5">Нелетающие птицы</option>
                    <option value="6">Опасные рептилии</option>
                    <option value="7">Неопасные рептилии</option>
                    <option value="8">Земноводные</option>
                    <option value="9">Насекомые</option>
                    <option value="10">Морские рыбы</option>
                    <option value="11">Пресноводные рыбы</option>
                </select><br> -->
                <input name="add_employee" type="submit" value="добавить">
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно редактирования сотрудника -->
<div id="editEmployeeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeEditEmployeeModal()">&times;</span>
        <h2>Редактировать сотрудника</h2>
        <form id="editEmployeeForm" action="http://localhost:84/employees/update" method="post">
            <input type="hidden" name="value[employee_id]" id="edit_employee_id">
            <div class="form__input">
                <label for="edit_employee_name">ФИО:</label>
                <input type="text" name="value[employee_name]" id="edit_employee_name"><br>

                <label for="edit_specialization_id">Специализация:</label>
                <select name="value[specialization_id]" id="edit_specialization_id">
                    <option value="1">зоология</option>
                    <option value="2">орнитология</option>
                    <option value="3">герпетология</option>
                    <option value="4">амфибиология</option>
                    <option value="5">ихтиология</option>
                    <option value="6">энтомология</option>
                </select><br>
                <label for="edit_department_id">Отдел:</label>
                <select name="value[department_id]" id="edit_department_id" required>
                <?php foreach ($data["departments"] as $emp): ?>
                    <option value="<?= htmlspecialchars($emp['department_id']) ?>">
                        <?= htmlspecialchars($emp['department_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
                <input type="submit" value="сохранить">
        </form>
        <h2>Удалить сотрудника из базы:</h2>
        <form action="http://localhost:84/employees/delete" method="post">
            <div class="form__input">
                <input type="hidden" name="employee_id_to_delete" id="employee_id_to_delete">
                <br>
                <input name="delete_employee" type="submit" value="удалить">
            </div>
        </form>
    </div>
    </form>
</div>
</div>

<script>
    function openEditEmployeeModal(employee) {
        document.getElementById("edit_employee_id").value = employee.employee_id;
        document.getElementById("edit_employee_name").value = employee.employee_name;
        document.getElementById("edit_department_id").value = employee.department_id;
        document.getElementById("employee_id_to_delete").value = employee.employee_id;

        const specializationMap = {
            "зоология": 1,
            "орнитология": 2,
            "герпетология": 3,
            "амфибиология": 4,
            "ихтиология": 5,
            "энтомология": 6
        };
        document.getElementById("edit_specialization_id").value = specializationMap[employee.specialization_name] || "";

        document.getElementById("editEmployeeModal").style.display = "block";
    }

    function closeEditEmployeeModal() {
        document.getElementById("editEmployeeModal").style.display = "none";
    }

    function openEmployeeAddModal() {
        document.getElementById("employeeAddModal").style.display = "block";
    }

    function closeEmployeeAddModal() {
        document.getElementById("employeeAddModal").style.display = "none";
    }

    // Закрытие по клику вне модального окна
    window.onclick = function(event) {
        const modal = document.getElementById("employeeAddModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>