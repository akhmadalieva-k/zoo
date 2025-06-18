<div class="container__body">
    <div class="container__page__body">
        <p><a href="http://localhost:84">На главную</a></p>
        <p><a href="http://localhost:84/employees/list">К списку сотрудников</a></p>
        <h3>Отдел:</h3>
        <?php $departmentId = $data["employee"]["department_id"];
        $departmentName = $data["employee"]["department_name"];
        echo "<a href='http://localhost:84/departments/department/$departmentId'>$departmentName</a>" ?>
        <br>
        <ul>
            <?php
            $titles = [
                "employee_id" => "Индивидуальный номер",
                "employee_name" => "имя",
                "specialization_name" => "специализация"
            ]; ?>
            <?php foreach ($data["employee"] as $key => $value): ?>
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
        <h3>Отвественный за животных:</h3>
        <?php foreach ($data["link"] as $key => $value): ?>
            <li>
                <?php print_r($value["species_rus"]);
                echo ": ";
                $idAnimal = $value["animal_id"];
                $nameAnimal = $value["animal_name"];
                echo "<a href='http://localhost:84/animals/animalPage/$idAnimal'>$nameAnimal</a>" ?>
            </li>
        <?php endforeach; ?>
    </div>
</div>