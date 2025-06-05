<p><a href="http://localhost:84">На главную</a></p>
<h3>Сотрудники:</h3>
<ol>
    <?php
    if (empty($data["employees"])): ?>
        <?= "сотрудников нет" ?>
        <?php else:
        foreach ($data["employees"] as $k => $v):
            $employeeName = $v["employee_name"];
            $employeeId = $v["employee_id"] ?>

            <li>
                <?php echo "<a href='http://localhost:84/page/employee/$employeeId'>$employeeName</a>" ?>
            </li>
    <?php endforeach;
    endif; ?>

</ol>
<br>

<h3>Животные:</h3>
<ol>
    <?php
    if (empty($data["animals"])): ?>
        <?= "животных нет" ?>
    <?php else: ?>
        <?php foreach ($data["animals"] as $key => $value):
            $animalName = $value["animal_name"];
            $animalId = $value["animal_id"] ?>
            <li>
                <?php echo $value["species_lat"] . " - " . "<a href='http://localhost:84/page/animal/$animalId'>$animalName</a>"; ?>
            </li>
    <?php endforeach;
    endif; ?>
</ol>