<div class="container-fluid my-5">
	
<div class="row">

<div class="card">
	<div class="col-lg-8 col-md-6 col-12 d-block">	
	<div class="card-body">
		
		 <form id="product_variant">
			 
			
			<div class="row">
				<div class="col-sm-12 col-12 d-block">
					
			 	<select class="form-select form-select-lg mb-3" name="products" id="products" aria-label="Default select example">
				  <option>Select Products</option>
				  <?php $products = get_posts(['post_type'=>'product','post_status'=>'publish','numberposts'=> -1]);  if(count($products) > 0): foreach($products as $key => $product): ?>
					<option value="<?= $product->ID; ?>"><?= $product->post_title; ?></option>
				  <?php endforeach; endif; ?>
				</select>
			
				</div>
			 </div>
			 <div class="row">
				 <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-block">
					 <div class="form-group">
						 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="part" id="part" placeholder="Part">
							  
							  <label for="part">Part <span class="text-danger">*</span></label>
							</div>
				 		
				 
					 </div>
				 </div>
				 <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-block">
					 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="inside_dimension" id="inside_dimension" placeholder="Inside Dimension">
							  
							  <label for="inside_dimension">Inside Dimension <span class="text-danger">*</span></label>
							</div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-block">
					 <div class="form-group">
						 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="bord_grade" id="part" placeholder="Bord Grade">
							  
							  <label for="part">Bord Grade <span class="text-danger">*</span></label>
							</div>
				 		
				 
					 </div>
				 </div>
				 <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-block">
					 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="colour" id="colour" placeholder="Colour">
							  
							  <label for="colour">Inside Dimension <span class="text-danger">*</span></label>
							</div>
				 </div>
			 </div>
			  <div class="row">
				 <div class="col-lg-4 col-md-4 col-sm-12 col-12 d-block">
					 <div class="form-group">
						 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="qty_bundle" id="qty_bundle" placeholder="Quantity Bundle">
							  
							  <label for="part">Bord Grade <span class="text-danger">*</span></label>
							</div>
				 		
				 
					 </div>
				 </div>
				 <div class="col-lg-4 col-md-4 col-sm-12 col-12 d-block">
					 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="qty_bale" id="qty_bale" placeholder="Quantity Bale">
							  
							  <label for="qty_bale">Inside Dimension <span class="text-danger">*</span></label>
							</div>
				 </div>
				  <div class="col-lg-4 col-md-4 col-sm-12 col-12 d-block">
					 <div class="form-floating mb-3">
							 <input type="text" class="form-control" name="prices" id="prices" placeholder="Prices">
							  
							  <label for="prices">Prices <span class="text-danger">*</span></label>
							</div>
				 </div>
				  <div class="form-group">
					  <button class="btn btn-primary" type="submit">Add Variant Product</button>
				  </div>
			 </div>
			 </form>
		</div>
	</div>
	</div>	
</div>

</div>