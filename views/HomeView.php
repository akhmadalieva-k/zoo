<?php
// print_r($data["departments"]);
?>
<ul>
    <?php foreach($data['headers'] as $keyH => $valueH):?>
        <li>
            <?php echo "<a href='http://localhost:84/$keyH'>$valueH</a>" ?>
        </li>
        <br>
    <?php endforeach ?>
</ul>

<h2>Перейти к отделу:</h2>
<ul>
    <?php foreach($data["departments"] as $keyArr => $valueArr): ?>
        <li>
            <?php echo "<a href='http://localhost:84/departments/department/$valueArr[department_id]'>$valueArr[department_name]</a>" ?>
        </li>
        <br>
    <?php endforeach ?>
</ul>
<br>
<h2>Добавить новый отдел:</h2>
<button onclick="openAddModal()">➕ Добавить отдел</button>

<div id="addModal" class="modal__add" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeAddModal()">&times;</span>
        <h2>добавить новое животное:</h2>
        <form action="http://localhost:84/departments/add" method="post">
            <div class="form__input">
                <label for="department_name">Название отдела:</label>
                <input type="text" name="department_name" id="department_name">
                <br>
                <input name="add_animal" type="submit" value="добавить">
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById("addModal").style.display = "block";
    }

    function closeAddModal() {
        document.getElementById("addModal").style.display = "none";
    }

    // Закрытие при клике вне окна
    window.onclick = function(event) {
        const modal = document.getElementById("addModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>