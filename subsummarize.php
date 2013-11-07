<?php

// generic function to subsummarize table rows
  //
  // $result: an array of objects/records pulled from a db and needing subsumarizing
  // $id_field: the matching fields in the table which identify the rows needing to be summarized
  // $summary_field: the field containing values to be summarized
  //
  function subsummarizeTable($result, $id_field, $summary_field) {
    // take the result array of objects,
    // iterate through them,
    // subsummarize by $id_field,
    // add another row with the subsummary

    if(is_array($result) &&  count($result) != 0){
      // get the first and last key of the array
      end($result);
      $last_key = key($result);
      reset($result);
      $first_key = key($result);

      $deltaEnd = $result[$first_key]->$id_field; // we'll increment this as we go
      $aggregating = 0;

      // this will become the resulting array of objects with subsummary rows
      $subsummarized = array();
      $i = 0;

      foreach($result as $key=>$row) {

        $deltaStart = $row->$id_field; // current row's id_field
        $x = $row->$summary_field;  // current row's summary value

        // CREATE subsummary row, while in the next
        if($deltaStart != $deltaEnd || $key == $last_key) { // insert the subsummary row if the deltas don't match,
                                                            // or we are on the last row
          if($key == $last_key) {
            //add in the current row to the $subsummarized array
            $row->type = 'secondary';
            $subsummarized[$i] = $row;
            $i++;
            $aggregating = $aggregating + $x;
          }
          // create a generic object which will become the subsummary row
          $summary_row = new stdClass();

          // add in the subsummary flag and the actual subsummary value
          $summary_row->type = 'subsummaryRow';
          $summary_row->subsummary = $aggregating;

          // next, put the new object into the new array of objects
          $var = array($summary_row);
          $subsummarized[$i] = $summary_row;
          $i++; // increment the insertion point

          // reset variables for the new row(s) of unique objects
          $aggregating = $x; // reset the aggregation
          $deltaEnd = $result[$key]->$id_field;; // set the new key

          if($key != $last_key) {
            //add in the current row to the $subsummarized array
            $row->type = 'primary';
            $subsummarized[$i] = $row;
            $i++; // increment the insertion point;
          }
        } else {

          $aggregating = $aggregating + $x;

          $row->type = $first_key == $key ? 'primary' : 'secondary';
          $subsummarized[$i] = $row;
          $i++; // increment the insertion point;
        }
      }
    } else {
      $subsummarized = FALSE;
    }

    return $subsummarized;

  }

}

?>