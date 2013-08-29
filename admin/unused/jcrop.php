<form class="form-horizontal" action="prof_pic_upload.php" method="POST" enctype="multipart/form-data" onsubmit="return checkForm()">
		  
		  <!-- <?php //echo $_SERVER['PHP_SELF']; ?>?adminid=<?php //echo $_GET['adminid']; ?> -->
		      
		      <!-- hidden crop params -->
	          <input type="hidden" id="x1" name="x1" />
	          <input type="hidden" id="y1" name="y1" />
	          <input type="hidden" id="x2" name="x2" />
	          <input type="hidden" id="y2" name="y2" />
		      
		      <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
		        	
		      <div class="control-group">
		      	<label for="image_file" class="control-label">File Selection</label>
                <div class="controls">
                	<input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" />
                </div>
		      </div>
		      
		      <div class="error"></div>
		      
		      <div class="step2">
	            
	            <div class="control-group">
		            <label class="control-label">Crop Region Selection</label>
		            <div class="controls">
		            	<img id="preview" />
		            </div>
	            </div>
	            
	            <div class="control-group">
	                <label for="filesize" class="control-label">File size</label>
	                <div class="controls">
	                	<input type="text" id="filesize" name="filesize" />
	                </div>
	            </div>
	            <div class="control-group">
	                <label for="filetype" class="control-label">Type</label>
	                <div class="controls">
	                	<input type="text" id="filetype" name="filetype" />
	                </div>
	            </div>
	            <div class="control-group">
	                <label for="filedim" class="control-label">Image dimension</label>
	                <div class="controls">
	                	<input type="text" id="filedim" name="filedim" />
	                </div>
	            </div>
	            <div class="control-group">
	                <label for="w" class="control-label">W</label>
	                <div class="controls">
	                	<input type="text" id="w" name="w" />
	                </div>
	            </div>
	            <div class="control-group">
	                <label for="h" class="control-label">H</label>
	                <div class="controls">
	                	<input type="text" id="h" name="h" />
	                </div>
	            </div>
	            
        	  </div>

		      <div class="form-actions">
		      	<button type="submit" class="btn btn-primary" name="upload">Upload</button>
		      </div>  	
	      </form>