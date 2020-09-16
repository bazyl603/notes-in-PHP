<div>
  <h3> Edit note</h3>
  <div>
    <?php if (!empty($params['note'])) : ?>
    <?php $note = $params['note']; ?>
    <form class="note-form" action="/?action=edit" method="post">
      <input name="id" type="hidden" value="<?php echo $note['id'] ?>" />
      <ul class="ul-form">

        <li>
          <label>Title<span class="required">*</span></label>
          <input type="text" name="title" class="field-long field-title" value="<?php echo $note['title'] ?>" />/>
        </li>

        <li>
          <label>Description:</label>
          <textarea name="description" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
        </li>

        <li>
          <input type="submit" value="Edit" class="add-btn" />
        </li>
        
      </ul>
    </form>
    <?php else : ?>
      <div>
        No data
        <a href="/"><button>Back to list</button></a>
      </div>
    <?php endif; ?>
  </div>
</div>