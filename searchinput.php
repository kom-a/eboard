<?php
echo '
        <form method="get" action="search.php">
            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Personal ID</span>
              </div>
              <input type="text" class="form-control" id="basic-url" name="id" aria-describedby="basic-addon3">
            </div>
            
            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Firstname</span>
              </div>
              <input type="text" class="form-control" id="basic-url" name="firstname" aria-describedby="basic-addon3">
            </div>
            
            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Lastname</span>
              </div>
              <input type="text" class="form-control" id="basic-url" name="lastname" aria-describedby="basic-addon3">
            </div>
            
            <div>
                <button type="submit" class="btn btn-dark">Найти</button>
            </div>
        </form>
    ';