<div>
  <h3> Create note</h3>
  <div>
    <form class="note-form" action="/?action=create" method="post">
      <ul class="ul-form">

        <li>
          <label>Title<span class="required">*</span></label>
          <input type="text" name="title" class="field-long field-title" />
        </li>

        <li>
          <label>Description:</label>
          <textarea name="description" class="field-long field-textarea"></textarea>
        </li>

        <li>
          <input type="submit" value="Create" class="add-btn" />
        </li>
        
      </ul>
    </form>
  </div>
</div>