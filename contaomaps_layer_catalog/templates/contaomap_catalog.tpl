<?php if (count($this->entries)): ?>
<div class="layout_full">
<?php foreach ($this->entries as $entry): ?>
<div class="item<?php echo $entry['class'] ? ' '.$entry['class'] : ''; ?>">
<?php foreach($entry['data'] as $k=>$v): ?>
   <div class="<?php echo $k; ?>"><?php echo $v['value']; ?></div>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<p class="info">Es wurde kein Eintrag ausgewählt.</p>
<?php endif; ?>