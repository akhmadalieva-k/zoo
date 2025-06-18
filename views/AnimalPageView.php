<div class="container__body">
    <div class="container__page__body">
        <p><a href="http://localhost:84">На главную</a></p>
        <p><a href="http://localhost:84/animals/list">К списку животных</a></p>
        <h3>Отдел:</h3>
        <?php
        $animalId = $data['animal']['animal_id'];
        $departmentId = $data["animal"]["department_id"];
        $departmentName = $data["animal"]["department_name"];
        echo "<a href='http://localhost:84/departments/department/$departmentId'>$departmentName</a>" ?>
        <br>
        <h3>Ответственный сотрудник:</h3>
        <?php if (empty($data["employee_link"])): ?>
            <?php echo "no"; ?>
        <?php else: ?>
        <?php $idEmployee = $data["employee_link"]["employee_id"];
            $nameEmployee = $data["employee_link"]["employee_name"];
            echo "<a href='http://localhost:84/employees/employeePage/$idEmployee'>$nameEmployee</a>";
        endif ?>
        <br>
        <button onclick="openAddResponsibleModal()">➕ Добавить нового ответственного</button>
        <br>
        <ul>
            <?php
            $titles = [
                "animal_id" => "Индивидуальный номер",
                "species_lat" => "видовое название лат.",
                "species_rus" => "видовое название рус.",
                "animal_name" => "имя",
                "animal_class" => "класс",
                "sex" => "пол",
                "age" => "возраст, лет",
                "arrival_date" => "дата поступления на содержание",
                "color" => "цвет",
                "state" => "охранный статус",
                "animal_description" => "описание",
                // "department_name" => "отдел"
            ]; ?>
            <?php foreach ($data["animal"] as $key => $value): ?>
                <?php foreach ($titles as $k => $v): ?>
                    <?php if ($key == $k): ?>
                        <li>
                            <?php echo $v . ": " . $value ?>
                        </li>
                        <br>
                <?php endif;
                endforeach; ?>
            <?php endforeach ?>
        </ul>
    </div>
</div>

<div id="addResponsibleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeAddResponsibleModal()">&times;</span>
        <h2>Добавить нового ответственного</h2>
        <form action="http://localhost:84/animals/addLink" method="post">
            <input type="hidden" name="animal_id" id="animal_id" value="<?= htmlspecialchars($animalId) ?>">
            <label for="employee_id">Выберите сотрудника:</label>
            <select name="employee_id" id="employee_id" required>
                <option value="0">
                    Нет ответственного
                </option>
                <?php foreach ($data["employee_list"] as $emp): ?>
                    <option value="<?= htmlspecialchars($emp['employee_id']) ?>">
                        <?= htmlspecialchars($emp['employee_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <input type="submit" value="Сохранить">
        </form>
    </div>
</div>

<script>
    function openAddResponsibleModal() {
        document.getElementById("addResponsibleModal").style.display = "block";
    }

    function closeAddResponsibleModal() {
        document.getElementById("addResponsibleModal").style.display = "none";
    }

    // По желанию — закрытие по щелчку вне окна
    window.onclick = function(event) {
        const modal = document.getElementById("addResponsibleModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>