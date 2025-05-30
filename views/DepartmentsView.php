<?php
foreach($data as $value)
{
    print_r($value);
} ?>
<ul>
    <?php foreach($data as $value): ?>
        <?php foreach($value as $key => $cell) ?>
        <li>
        <?php echo "<a href='http://localhost:84/employee/redact/$key'>$cell</a>"; ?>
        </li>
        <?php endforeach ?>
</ul>