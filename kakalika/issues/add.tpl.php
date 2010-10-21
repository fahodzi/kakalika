<h4>Add new Issue</h4>
<?php
$this->forms->add("TableLayout", 1, 2)
     ->add($this->forms->create("TextField", "Title", "title"), 0, 0)
     ->add(
        $this->forms->create(
            "TextArea", 
            "Description", 
            "description",
            "Please provide a description of the problem"
        ), 0, 0)
     ->add(
        $this->forms->create(
            "TextField",
            "Tags",
            "tags"
        ), 0, 0);
echo $this->forms;
var_dump($fields);