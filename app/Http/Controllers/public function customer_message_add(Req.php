    public function customer_message_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|alpha_num_space_colon|max:35',
            'email_address' => 'required|email',
            'subject' => 'nullable|max:40',
            'phone' => 'numeric|digits_between:0,11',
            'message'=> 'required|max:500',
        ],[
            'email_address.required' => 'Please enter your <strong>email</strong>.',
            'email_address.email' => 'Please enter a valid <strong>email</strong>.',
            'name.required'=>'Please enter your <strong>name</strong>.',
            'name.alpha_num_space_colon' => 'Name can be contain <strong>Alpha, Number, Space and Colon</strong>.',
            'name.max' => 'Name contains <strong>maximum 35 characters</strong>.',
            'subject.max' => 'Subject contain <strong>maximum 40 characters</strong>.',
            'phone.numeric' => 'Please enter a <strong>valid</strong> phone number.',
            'phone.digits_between' => 'Phone number contains <strong>maximum 11 digits</strong>.',
            'message.required'=> 'Please enter your <strong>Message</strong>.',
            'message.max' => 'Message contains maximum <strong>500</strong> characters.',
        ]);

        // If Single Validation Fails
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->all();
        $validated['created_at'] = Carbon::now();

        $inserted = CustomerMessage::insert(
            $validated,
        );

        if($inserted != true) {
            return back()->with('Cfaild','Something Worng! Please try again.');
        }

        return back()->with('Csuccess','Message Send Success!');
    }


    // Get Search Product by using Ajax Request
    public function search_product(Request $request)
    {   
        $category_id = $request->category;
        $input_text = $request->search_value;

        $search_result = Product::where('category_id',$category_id)
                                ->where('title','LIKE','%'.$input_text.'%')
                                ->where('status',1)
                                ->rightJoin('categories','categories.id','=','products.category_id')
                                ->select('products.*','categories.name')
                                ->get();

        return json_encode($search_result, true);
    }


    // Show indivisual Category Product
    public function browse_category($category_name) {
        $category = preg_replace('/_/i',' ',$category_name);
        $get_category_id = Category::where('name',$category)->firstOrFail()->id;

        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        $data['products'] = Product::where('category_id',$get_category_id)
                                    ->where('status',1)
                                    ->join('categories','categories.id','=','products.category_id')
                                    ->select('products.*','categories.name')
                                    ->get();

        return view('public.category_browse',$data);

    }



         */
    public function about_us()
    {
        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        $data['about_us'] = AboutUs::orderBy('id','desc')->first();
        $data['gallery_images']= AboutUsGallery::orderBy('id','desc')->get();
        return view('public.about_us',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contact_us()
    {
        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        return view('public.contact_us',$data);
    }



    public function subscriber_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ],[
            'email.required' => 'Please enter your <strong>email</strong>.',
            'email.email' => 'Please enter a valid <strong>email</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->all();

        $inserted_data = Subscriber::insert([
            'email' => $validated['email'],
            'created_at' => Carbon::now(),
        ]);
        if($inserted_data != true) {
            $validator->errors()->add('eamil', 'Something worng! Please try again.');
            return back()->withErrors($validator)->withInput();
        }

        return back()->with('success','Subscription <strong>Success!</strong>.');


    }


     /**
     * Find Speacific Product By using Ajax.
     *
     * @return \Illuminate\Http\Response
     */
    public function find_product(Request $request)
    {
        $id = $request->product_identity;
        $product_info = Product::find($id);
        return json_encode($product_info,true);
    }




     public function update_profile_image(Request $request , $user_identity)
    {
        // Find User Id From User Identity
        $get_user_id = $this->user_identity($user_identity)->id;

        // Validate
        $validated = $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,svg',
        ],[
            'image.required' => 'Please enter your <strong>Profile Image</strong>.',
            'image.mimes' => 'Image must be type of <strong>jpg, jpeg, png, svg</strong>.',
        ]);

        if($request->hasFile('image')){
            $image_file = Image::make($validated['image'])->orientate();
            $extention = $validated['image']->getClientOriginalExtension();
            $image_new_name = Str::lower(User::find($get_user_id)->username . '_' . uniqid() . '_' . $get_user_id . '.' . $extention);

            // Update image to database
            $image_updated = User::find($get_user_id)->update([
                'profile_image' => $image_new_name,
            ]);

            if($image_updated === true){
                // Image Resizing Processing Start
                $width = $image_file->width();
                $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                // Dynamically Image Resizing & Move to Targeted folder
                if($width > 0 && $width < 2048){
                    $new_width = $width;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }else{
                    for($i = 0; $i < count($resulation_break_point); $i++){
                        if($i != count($resulation_break_point) -1){
                            if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                try {
                                    $image_file->resize($new_width, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
                                } catch (\Exception $e) {
                                    return back()->with('faild','Image Upload <strong>Faild!</strong>');
                                }
                            }
                        }
                    }
                    if($width > 8192){
                        $new_width = 2048;
                        try {
                            $image_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else{
                return back()->with('faild','Something Worng! Please try again');
            }
        }





          // Show Customer Message Page with all of messages
    public function customer_message()
    {
        $data = CustomerMessage::orderBy('id','desc')->get();
        return view('dashboard.custommer_message',['data'=>$data]);
    }

    // Delete Custommer Message
    public function customer_message_delete($id)
    {
        $deleted = CustomerMessage::find($id)->delete();

        if($deleted != true){
            return back()->with('faild', 'Something Worng! Please try again.');
        }

        return back()->with('success','Message Deleted Success!');
    }





     public function updateAgreement(Request $request)
    {
        $input = $request->all();
		$rules = array ('agreementID' => 'required|numeric',
						'revision' => 'required|numeric',
						'itemID' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['agreementID.required' => 'Please input the agreement id',
					'agreementID.numeric' => 'Please input the agreement id in correct format',
					'revision.required' => 'Please input the revision',
					'revision.numeric' => 'Please input the revision in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'balance.required' => 'Please input the price',
					'balance.numeric' => 'Please input the price in correct format',];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) {
			return Redirect::to('supplier/create')->withErrors($validator);
		}else {
			AgreementLine::where("agreementID", $request->agreementID)->where("revision", $request->revision)->where("itemID", $request->itemID)->update(["balance"=>$request->balance]);
			return redirect('supplier')->with('success','Apply Supplier Information Sucessfully!');
		}
    }