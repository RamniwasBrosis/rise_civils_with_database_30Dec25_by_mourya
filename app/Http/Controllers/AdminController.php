<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\orders_confirm;
use App\Models\User;
use App\Models\rise\PageSetting;
use Carbon\Carbon;

//rise
use App\Models\rise\TypesOf;
use App\Models\rise\Categories;
use App\Models\rise\Subjects;
use App\Models\rise\Posts;
use App\Models\rise\Sliders;
use App\Models\rise\Chapter;
use App\Models\rise\Headings;
use App\Models\rise\Courses;
use App\Models\rise\AdminContactUs;
use App\Models\rise\AboutUs;

class AdminController extends Controller
{

    public function userLogin(){
        return view('login');
    }

    // rise civils
    public function index()
    {
        return view('admin.login');
    }

    // rise civils
    public function login(Request $request)
    {

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
        }

        return back()->withErrors(['username' => 'Invalid credentials.'])->withInput();
    }

    public function dashboard()
    {
        $totalUsers = User::where('role', 0)->count();
        $todaysUser = User::whereDate('created_at', Carbon::today())->count();

        $totalBookedTickets = orders_confirm::where('status', 'Paid')->count();
        $todayBookedTickets = orders_confirm::where('status', 'Paid')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // total users collection
        $totalUsersCollection = orders_confirm::where('role', 'User')
            ->where('status', 'Paid')
            ->sum('total_amount');

        // today's users collection
        $todaysUsersCollection = orders_confirm::where('role', 'User')
            ->where('status', 'Paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        // total admin collection
        $totalAdminCollection = orders_confirm::whereIn('role', ['super-admin', 'sub-admin'])
            ->where('status', 'Paid')
            ->sum('total_amount');


        // today's admin collection
        $todaysAdminCollection = orders_confirm::whereIn('role', ['super-admin', 'sub-admin'])
            ->where('status', 'Paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        // total admin tickets
        $totalTicketAdmin = orders_confirm::where('role', ['super-admin', 'sub-admin'])
            ->where('status', 'Paid')
            ->count();

        // today's admin tickets
        $totalTicketTodayAdmin = orders_confirm::whereIn('role', ['super-admin', 'sub-admin'])
            ->where('status', 'Paid')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // total user tickets
        $totalTicketUsers = orders_confirm::where('role', 'User')
            ->where('status', 'Paid')
            ->count();

        // today's user tickets
        $totalTicketTodayUsers = orders_confirm::where('role', 'User')
            ->where('status', 'Paid')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $adminData = Admin::first();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'todaysUser' => $todaysUser,
            'totalBookedTickets' => $totalBookedTickets,
            'todayBookedTickets' => $todayBookedTickets,
            'totalUsersCollection' => $totalUsersCollection,
            'todaysUsersCollection' => $todaysUsersCollection,

            'totalTicketAdmin' => $totalTicketAdmin,
            'totalTicketTodayAdmin' => $totalTicketTodayAdmin,
            'totalTicketUsers' => $totalTicketUsers,
            'totalTicketTodayUsers' => $totalTicketTodayUsers,
            'totalAdminCollection' => $totalAdminCollection,
            'todaysAdminCollection' => $todaysAdminCollection,
            'adminData' => $adminData
        ]);
    }

    // Types se related methods
    public function typesOf()
    {
        $types = TypesOf::get();
        return view('admin.types.index', compact('types'));
    }

    public function addTypes()
    {
        return view('admin.types.create');
    }

    public function storeTypes(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable',
            'page_content' => 'nullable',
            'order_no' => 'nullable|numeric',
            'status' => 'required|in:1,0',
        ]);

        // Check if the type already exists
        $typeExists = TypesOf::where('type', $validated['type'])->exists();

        if ($typeExists) {
            return redirect()->back()->withInput()->with('error', 'This type already exists!');
        }

        //  Check if order_no already exists (if provided)
        if (!empty($validated['order_no'])) {
            $orderExists = TypesOf::where('order_no', $validated['order_no'])->exists();

            if ($orderExists) {
                return redirect()->back()->withInput()->with('error', 'This order number already exists!');
            }
        }

        $type = new TypesOf();
        $type->type = $validated['type'];
        $type->title = $validated['title'];
        $type->description = $validated['description'];
        $type->page_content = $validated['page_content'];
        $type->status = $validated['status'];
        $type->order_no = $validated['order_no'];
        $type->save();

        return redirect()->route('admin.types')->with('success', 'Type added successfully!');
    }

    public function editTypes($id)
    {
        $typesData = TypesOf::findOrFail($id);
        return view('admin.types.edit',[
                'typesData' => $typesData
            ]);

    }

    public function updateTypes(Request $request, $id)
    {
        // 1. Find the existing model instance. This is required when using the $id parameter.
        $type = TypesOf::findOrFail($id);

        // 2. Validation: Ensure the 'type' is unique, ignoring the current record's ID
        $validated = $request->validate([
            'type' => 'required|string|max:255|unique:table_types,type,' . $type->id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable',
            'page_content' => 'nullable',
            'status' => 'required|in:1,0',
            'order_no' => 'numeric | nullable',
        ]);

        // 3. Update the model instance
        $type->type = $validated['type'];
        $type->title = $request->title;
        $type->description = $request->description;
        $type->page_content = $request->page_content;
        $type->status = $validated['status'];
        $type->order_no = $validated['order_no'];

        // 4. Save the changes and redirect with corrected message
        if ($type->save()) {
            return redirect()->route('admin.types')->with('success', 'Type updated successfully!');
        } else {
            // Corrected error message location
            return redirect()->back()->with('error', 'Something went wrong while updating!');
        }
    }

    public function deleteType($id)
    {
        $type = TypesOf::findOrFail($id);

        $type->delete();

        return redirect()->route('admin.types')->with('success', 'Type deleted successfully!');
    }

    // Categories se related methods
    public function category()
    {
        $categories = Categories::with(['type', 'parent.parent'])
            ->orderBy('created_at', 'desc')
            ->where('status', 1)
            ->get();

        return view('admin.categories.index', compact('categories'));
    }


    public function addCategory()
    {
        $types = TypesOf::where('status', 1)->get();

        //  Only parent categories (no child ones)
        $categories = Categories::whereNull('category_id')
            ->where('status', 1)
            ->get();

        $order_no = Categories::whereNull('category_id')
            ->where('status', 1)
            ->orderBy('order_no', 'desc')
            ->first();

        $order_no = $order_no && $order_no->order_no ? $order_no->order_no + 1 : 1;

        return view('admin.categories.create', compact('types', 'categories', 'order_no'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'type_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'order_no' => 'nullable',
            'short_description' => 'nullable|string',
            'status' => 'required|in:1,0',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'isFeature' => 'nullable|boolean'
        ]);

        $category = new Categories();
        $category->name = $validated['category'];
        $category->type_id = $validated['type_id'] ?? null;
        $category->status = $validated['status'];
        $category->category_id = $validated['category_id'] ?? null;
        $category->order_no = $validated['order_no'] ?? null;
        $category->description = $validated['short_description'] ?? null;
        $category->isFeature = $validated['isFeature'] ?? null;

        // Store file if uploaded
        if ($request->hasFile('cat_image')) {
            $file = $request->file('cat_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $category->cat_image = 'uploads/categories/' . $filename;
        }

        $category->save();

        return redirect()->route('admin.category')
            ->with('success', 'Category saved successfully!');
    }

    public function editCategory($id)
    {
        $category = Categories::findOrFail($id);
        $types = TypesOf::where('status', 1)->get();

        // Only load parent categories (excluding current one) with children
        $categories = Categories::whereNull('category_id')
            ->where('status', 1)
            ->where('id', '!=', $id)
            ->with('children')
            ->get();

        return view('admin.categories.edit', compact('category', 'types', 'categories'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'type_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'order_no' => 'nullable|string',
            'short_description' => 'nullable|string',
            'status' => 'required|in:1,0',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'isFeature' => 'nullable|boolean'
        ]);

        // $order_no_exist = Categories::where('order_no', $request->order_no)->first();
        // if($order_no_exist){
        //      return redirect()->route('admin.editCategory',$id)->with('error', 'This "Order No" is ready exit in another category!');
        // }

        $category = Categories::findOrFail($id);

        $category->name = $validated['category'];
        $category->type_id = $validated['type_id'] ?? null;
        $category->status = $validated['status'];
        $category->category_id = $validated['category_id'] ?? null;
        $category->order_no = $validated['order_no'] ?? null;
        $category->description = $validated['short_description'] ?? null;
        $category->isFeature = $validated['isFeature'] ?? null;

        if ($request->hasFile('cat_image')) {
            if ($category->cat_image && file_exists(public_path($category->cat_image))) {
                unlink(public_path($category->cat_image)); // delete old file
            }

            $file = $request->file('cat_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);

            $category->cat_image = 'uploads/categories/' . $filename;
        }

        $category->save();

        return redirect()->route('admin.category')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id){

        $Category = Categories::find($id);
        if (!$Category) {
            return redirect()->route('admin.category')->with('error', 'Category not found.');
        }
        if ($Category->delete()) {
            return redirect()->route('admin.category')->with('success', 'Category successfully deleted.');
        } else {
            return redirect()->route('admin.category')->with('error', 'Failed to delete Category. Please try again.');
        }

    }

    public function getOrderNoByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $mainCategory = Categories::find($categoryId);
        if (!$mainCategory) {
            return response()->json(['order_no' => '']);
        }

        $mainOrderNo = $mainCategory->order_no;

        $lastSubCategory = Categories::where('category_id', $categoryId)
            ->orderBy('order_no', 'desc')
            ->first();

        if ($lastSubCategory && strpos($lastSubCategory->order_no, '.') !== false) {

            $parts = explode('.', $lastSubCategory->order_no);
            $nextDecimal = isset($parts[1]) ? ((int)$parts[1] + 1) : 1;
            $nextOrderNo = $mainOrderNo . '.' . $nextDecimal;
        } else {

            $nextOrderNo = $mainOrderNo . '.1';
        }

        return response()->json(['order_no' => $nextOrderNo]);
    }

    // Chapters se related methods
    public function chapter(Request $request){

        $chapters = Chapter::with('Category')->orderBy('created_at', 'desc')->get();

        return view('admin.Chapter.index', compact('chapters'));
    }

    public function addChapter(Request $request){

        $categories = Categories::whereNull('category_id')
                        ->where('status', 1)
                        ->with('children')
                        ->get();

        return view('admin.Chapter.create', [
                'categories' => $categories,
            ]);
    }

    public function storeChapter(Request $request){
        $validated = $request->validate([
            'chapter' => 'required|string|max:255',
            'category_id' => 'nullable|numeric',
            'order_no' => 'nullable',
            'status' => 'required|in:1,0',
            'isFeature' => 'nullable|boolean'
        ]);

        $category = new Chapter();
        $category->name = $validated['chapter'];
        $category->status = $validated['status'];
        $category->category_id = $validated['category_id'] ?? null;
        $category->order_no = $validated['order_no'] ?? null;
        $category->isFeature = $validated['isFeature'] ?? null;
        $category->save();

        return redirect()->route('admin.chapter')
            ->with('success', 'Chapter saved successfully!');
    }

    public function editChapter(Request $request, $id){

        $chapter = Chapter::findOrFail($id);

        $categories = Categories::whereNull('category_id')
                                ->where('status', 1)
                                ->with('children')
                                ->get();

        return view('admin.Chapter.edit', compact('chapter', 'categories'));
    }

    public function updateChapter(Request $request, $id){
        $validated = $request->validate([
            'chapter' => 'required|string|max:255',
            'category_id' => 'nullable|numeric',
            'order_no' => 'nullable|string',
            'status' => 'required|in:1,0',
            'isFeature' => 'nullable|boolean'
        ]);

        $chapter = Chapter::findOrFail($id);

        $chapter->name = $validated['chapter'];
        $chapter->status = $validated['status'];
        $chapter->category_id = $validated['category_id'] ?? null;
        $chapter->order_no = $validated['order_no'] ?? null;
        $chapter->isFeature = $validated['isFeature'] ?? null;

        $chapter->save();

        return redirect()->route('admin.chapter')->with('success', 'chapter updated successfully!');
    }

    public function deleteChapter($id){

        try {

            $Chapter = Chapter::find($id);

            if (!$Chapter) {
                return redirect()->route('admin.chapter')->with('error', 'Chapter not found.');
            }
            if ($Chapter->delete()) {
                return redirect()->route('admin.chapter')->with('success', 'Chapter successfully deleted.');
            }

        }catch (QueryException $e) {

            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('admin.chapter')
                    ->with('error', 'Cannot delete this record because it is linked with other data.');
            }

            // Any other database error
            return redirect()
                ->route('admin.chapter')
                ->with('error', 'Cannot delete this record because it is linked with other data.');
        } catch (\Exception $e) {
            // Generic error
            return redirect()
                ->route('admin.chapter')
                ->with('error', 'Cannot delete this record because it is linked with other data.');
        }

    }

    public function getOrderNoByChapter(Request $request)
    {
        $categoryId = $request->category_id;

        $mainCategory = Categories::find($categoryId);
        if (!$mainCategory) {
            return response()->json(['order_no' => '']);
        }

        $mainOrderNo = $mainCategory->order_no;

        $lastSubCategory = Chapter::where('category_id', $categoryId)
            ->orderBy('order_no', 'desc')
            ->first();

        if ($lastSubCategory && strpos($lastSubCategory->order_no, '.') !== false) {

            $parts = explode('.', $lastSubCategory->order_no);
            $nextDecimal = isset($parts[1]) ? ((int)$parts[1] + 1) : 1;
            $nextOrderNo = $mainOrderNo . '.' . $nextDecimal;
        } else {

            $nextOrderNo = $mainOrderNo . '.1';
        }

        return response()->json(['order_no' => $nextOrderNo]);
    }

    // pages se related methods
    public function postsList()
    {
        $posts = Posts::with(['category.parent.parent'])
                   ->orderBy('created_at', 'desc')
                   ->get();
        return view('admin.Posts.index', [
            'posts' => $posts
        ]);
    }

    public function addPosts()
    {
        // $categories = Categories::with('children')->whereNull('category_id')->get();

         $categories = Categories::with(['children', 'chapters.parent'])->whereNull('category_id')->get();

        return view('admin.Posts.create', [
            'categories' => $categories
        ]);
    }

    public function storePosts(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|numeric|exists:chapters,id',
            'status' => 'required|in:1,0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10048',
            'pdf' => 'nullable|mimes:pdf|max:15000',
            'description' => 'required|string',
            'order_no' => 'nullable|numeric|unique:table_posts,order_no',
            'content' => 'required|string',
            'pass_protected' => 'nullable|boolean',
            'isFeature' => 'nullable|boolean',
            'showOnFront' => 'nullable|boolean'
        ]);



        $post = new Posts();
        $post->name = $request->name;
        $post->category_id = $request->category_id;
        $post->status = $request->status;
        $post->description = $request->description;
        $post->content = $request->content;
        $post->pass_protected = $request->pass_protected;
        $post->order_no = $request->order_no;
        $post->isFeature = $request->isFeature;
        $post->showOnFront = $request->showOnFront;


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_img_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts/images'), $imageName);
            $post->image = 'uploads/posts/images/' . $imageName;
        }

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $pdfName = time() . '_pdf_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts/pdf'), $pdfName);
            $post->pdf = 'uploads/posts/pdf/' . $pdfName;
        }

        $post->save();

        return redirect()->route('admin.posts')
            ->with('success', 'Post added successfully!');
    }

    public function editPosts($id)
    {
        $post = Posts::with('category')->findOrFail($id);

        // $categories = Categories::with('children')->whereNull('category_id')->get();

         $categories = Categories::with(['children', 'chapters.parent'])->whereNull('category_id')->get();

        return view('admin.Posts.edit', compact('post', 'categories'));
    }

    public function updatePosts(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|numeric|exists:chapters,id',
            'status' => 'required|in:1,0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10048',
            'pdf' => 'nullable|mimes:pdf|max:15000',
            'description' => 'required|string',
            'content' => 'required|string',
            'pass_protected' => 'nullable|boolean',
            'order_no' => 'nullable|numeric|unique:table_posts,order_no',
            'isFeature' => 'nullable|boolean',
            'showOnFront' => 'nullable|boolean'
        ]);

        $post = Posts::findOrFail($id);

        $post->name = $request->name;
        $post->category_id = $request->category_id;
        $post->status = $request->status;
        $post->description = $request->description;
        $post->content = $request->content;
        $post->pass_protected = $request->pass_protected;
        $post->order_no = $request->order_no;
        $post->isFeature = $request->isFeature;
        $post->showOnFront = $request->showOnFront;


        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            $file = $request->file('image');
            $imageName = time() . '_img_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts/images'), $imageName);
            $post->image = 'uploads/posts/images/' . $imageName;
        }

        if ($request->hasFile('pdf')) {
            if ($post->pdf && file_exists(public_path($post->pdf))) {
                unlink(public_path($post->pdf));
            }
            $file = $request->file('pdf');
            $pdfName = time() . '_pdf_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts/pdf'), $pdfName);
            $post->pdf = 'uploads/posts/pdf/' . $pdfName;
        }

        $post->save();

        return redirect()->route('admin.posts')
            ->with('success', 'Post updated successfully!');
    }

    public function deletePost($id)
    {
        $post = Posts::findOrFail($id);
        if($post){
            $post->delete();
            return redirect()->route('admin.posts')->with('success', 'Page deleted successfully!');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function subjects()
    {
        $subjects = Subjects::with(['category', 'type'])->where('status', 1)->get();
        return view('admin.subjects.index', [
                'subjects' => $subjects
            ]);
    }

    public function addSubjects()
    {
        $types = TypesOf::where('status', 1)->get();
        $categories = Categories::where('status', 1)->get();
        return view('admin.subjects.create', [
                'categories' => $categories,
                'types' => $types,
            ]);
    }

    public function getCategoriesByType($typeId)
    {
        // Fetch categories where the foreign key matches the selected type ID
        $categories = Categories::where('type_id', $typeId)
                                // Select only the necessary columns for the dropdown
                                ->select('id', 'name')
                                ->get();

        // Return the collection as a JSON response
        return response()->json($categories);
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'status' => 'required|in:1,0',
        ]);

        $categories = new Subjects();

        $categories->name = $validated['name'];
        $categories->type_id = $validated['type_id'] ?? null;
        $categories->category_id = $validated['category_id'] ?? null;
        $categories->status = $validated['status'];

        if ($categories->save()) {
            return redirect()->route('admin.subject')->with('success', 'Subject added successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function usersList(){
        $users = User::where('status', 'active')->get();

        return view('admin/users/index', compact('users'));
    }

    function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function pageSlider()
    {
        return view('admin.Sliders.add');
    }

    public function pageSliderList()
    {
        $sliders = Sliders::get();
        return view('admin.Sliders.index', [
                'sliders' => $sliders
            ]);
    }

    public function storePageSliders(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10048',
            'status' => 'required|in:1,0',
            'image_url' => 'nullable|string',
            'forYoutube' => 'nullable|boolean',
        ]);

        $slider = new Sliders();

        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sliders'), $filename);
            $slider->image = 'uploads/sliders/' . $filename;
        }

        $slider->status = $validated['status'];
        $slider->image_url = $validated['image_url'] ?? '';
        $slider->forYoutube = $validated['forYoutube'] ?? '';
        $slider->save();

        return redirect()->route('admin.pageSliderList')
            ->with('success', 'Slider added successfully!');
    }

    public function editPageSlider($id)
    {
        $slider = Sliders::where('id', $id)->first();

        return view('admin.Sliders.edit', [
                'slider' => $slider
            ]);
    }

    public function updatePageSlider(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10048',
            'status' => 'required|in:1,0',
            'image_url' => 'nullable|string',
            'forYoutube' => 'nullable|boolean',
        ]);

        $slider = Sliders::findOrFail($id);

        //  Update image only if new file uploaded
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if (!empty($slider->image) && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sliders'), $filename);
            $slider->image = 'uploads/sliders/' . $filename;
        }

        $slider->status = $validated['status'];
        $slider->image_url = $validated['image_url'] ?? '';
        $slider->forYoutube = $validated['forYoutube'] ?? 0;
        $slider->save();

        return redirect()->route('admin.pageSliderList')
            ->with('success', 'Slider updated successfully!');
    }

    public function deletePageSlider($id)
    {
        $slider = Sliders::findOrFail($id);

        if (!empty($slider->image) && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $slider->delete();

        return redirect()->route('admin.pageSliderList')
            ->with('success', 'Slider deleted successfully!');
    }

    public function pageSetting()
    {
        $pageData = PageSetting::first();

        return view('admin/PageSetting/update-form', compact('pageData'));
    }

    public function updatePageSetting(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'instagram' => 'nullable|url',
            'pinterest' => 'nullable|url',
        ]);

        $setting = PageSetting::first(); // assuming only one setting record
        if (!$setting) {
            $setting = new PageSetting();
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/logo'), $filename);
            $setting->logo_image = 'uploads/logo/' . $filename;
        }

        // Update all fields
        $setting->phone = $request->phone;
        $setting->whatapp_number = $request->whatsapp;
        $setting->email = $request->email;
        $setting->address = $request->address;
        $setting->aboutus_content = $request->about;
        $setting->facebook_url = $request->facebook;
        $setting->twitter_url = $request->twitter;
        $setting->youtube_url = $request->youtube;
        $setting->instagram_url = $request->instagram;
        $setting->pinsert_url = $request->pinterest;

        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function downloadPdf($slug)
    {
        // Find post by slug instead of ID
        $post = Posts::where('slug', $slug)->firstOrFail();

        // Check pass_protected
        if ($post->pass_protected && !Auth::check()) {
            return redirect()->route('front.login')
                             ->with('error', 'Please login to access this PDF.');
        }

        // Use the exact path from DB
        $filePath = public_path($post->pdf);

        if (!file_exists($filePath)) {
            abort(404, 'PDF not found.');
        }

        return response()->download($filePath);
    }



    public function uploadPDF(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/ckeditor'), $filename);
            $url = asset('uploads/ckeditor/'.$filename);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url
            ]);
        }

        return response()->json(['uploaded' => 0, 'error' => ['message' => 'No file uploaded.']]);
    }

    // home page section
    public function listHeading()
    {
        $headings = Headings::orderBy('created_at', 'desc')->get();
        return view('admin.Headings.index',[
                'headings' => $headings
            ]);
    }

    public function addHeading()
    {
        $headings = Headings::whereNull('heading_id')->get();
        return view('admin.Headings.create', compact('headings'));
    }

    public function storeHeading(Request $request)
    {
        $request->validate([
            'heading_id' => 'nullable|exists:table_rise_headings,id',
            'name'       => 'nullable|string|max:255',
            'title'      => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'content'    => 'nullable|string',
            'link'       => 'nullable|string',
            'isFeatured' => 'required|in:0,1',
            'order_no'   => 'nullable|numeric',
            'status'     => 'required|in:0,1',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10096',
        ]);

        $data = $request->all();

        // If no parent selected, store NULL (means parent heading)
        $data['heading_id'] = $request->heading_id ?? null;

        // Upload image if available
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/headings'), $imageName);
            $data['image'] = $imageName;
        }

        // Create heading (parent or child)
        $heading = Headings::create($data);

        return response()->json([
            'status'  => true,
            'message' => $request->heading_id
                            ? 'Child heading created successfully!'
                            : 'Parent heading created successfully!',
            'data'    => $heading
        ]);
    }

    public function editHeading($id)
    {
        $heading = Headings::find($id);
        $headings = Headings::whereNull('heading_id')->get();

        if (!$heading) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        return view('admin.Headings.edit',[
                'heading' => $heading,
                'headings' => $headings
            ]);
    }

    public function updateHeading(Request $request, $id)
    {
        $request->validate([
            'heading_id' => 'nullable|exists:table_rise_headings,id',
            'name'       => 'nullable|string|max:255',
            'title'      => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'content'    => 'nullable|string',
            'link'       => 'nullable|string',
            'isFeatured' => 'required|in:0,1',
            'order_no'   => 'nullable|numeric',
            'status'     => 'required|in:0,1',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10096',
        ]);

        $heading = Headings::find($id);

        if (!$heading) {
            return response()->json([
                'status'  => false,
                'message' => 'Heading not found.'
            ], 404);
        }

        $heading->heading_id  = $request->heading_id ?: null;
        $heading->name        = $request->name;
        $heading->title       = $request->title;
        $heading->description = $request->description;
        $heading->content     = $request->content;
        $heading->link        = $request->link;
        $heading->isFeatured  = $request->isFeatured;
        $heading->order_no    = $request->order_no;
        $heading->status      = $request->status;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/headings'), $imageName);
            $heading->image = $imageName;
        }

        $heading->save();

        return response()->json([
            'status'  => true,
            'message' => 'Heading updated successfully!',
            'data'    => $heading
        ]);
    }

    public function deleteHeading($id)
    {
        $heading = Headings::findOrFail($id);

        $heading->delete();

        return redirect()->route('admin.listHeading')
            ->with('success', 'Heading deleted successfully!');
    }

    // courses
    public function coursesList()
    {
        $courses = Courses::orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('admin.Courses.index', [
                'courses' => $courses
            ]);
    }

    public function createCourse()
    {
        return view('admin.Courses.create');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link'        => 'nullable|string',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'status'      => 'required|in:0,1',
        ]);

        $data = $request->only([
            'title',
            'link',
            'description',
            'price',
            'status'
        ]);

        // checkboxes
        $data['isFeatured']  = $request->has('isFeatured') ? 1 : 0;
        $data['showOnFront'] = $request->has('showOnFront') ? 1 : 0;

        // thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses'), $name);
            $data['thumbnail'] = 'uploads/courses/' . $name;
        }

        Courses::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Course saved successfully!'
        ]);
    }

    public function editCourse($id)
    {
        $courses = Courses::findOrFail($id);

        return view('admin.Courses.edit', [
                'courses' => $courses
            ]);
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Courses::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link'        => 'nullable|string',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'status'      => 'required|in:0,1',
        ]);

        $data = $request->only([
            'title',
            'link',
            'description',
            'price',
            'status'
        ]);

        $data['isFeatured']  = $request->has('isFeatured') ? 1 : 0;
        $data['showOnFront'] = $request->has('showOnFront') ? 1 : 0;

        // Thumbnail update
        if ($request->hasFile('thumbnail')) {

            // delete old image
            if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
                unlink(public_path($course->thumbnail));
            }

            $file = $request->file('thumbnail');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses'), $name);

            $data['thumbnail'] = 'uploads/courses/' . $name;
        }

        $course->update($data);

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully!');
    }

    public function deleteCourse($id)
    {
        $course = Courses::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully!');
    }

    public function aboutUs()
    {
        // Always load single record
        $about = AboutUs::first();

        // Auto-create row if empty
        if (!$about) {
            $about = AboutUs::create([
                'title' => 'About Us',
                'description' => '',
                'image' => '',
            ]);
        }

        return view('admin.aboutus', compact('about'));
    }

    public function updateAboutUs(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $about = AboutUs::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();

            // public_html/uploads/about
            $image->move(public_path('uploads/about'), $filename);

            $about->image = 'uploads/about/' . $filename;
        }

        $about->title = $request->title;
        $about->description = $request->description;
        $about->save();

        return redirect()
            ->route('admin.aboutUs')
            ->with('success', 'About page updated successfully');
    }

    public function contactUs()
    {
        // Always fetch ONE record
        $contact = AdminContactUs::first();

        // If table is empty, create default row
        if (!$contact) {
            $contact = AdminContactUs::create([
                'title' => 'Contact Us',
                'status' => 1
            ]);
        }

        return view('admin.contactus', compact('contact'));
    }

    public function updateContactUs(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'status'      => 'required|in:0,1',
        ]);

        $contact = AdminContactUs::findOrFail($id);

        $contact->update($request->only([
            'title',
            'description',
            'address',
            'phone',
            'email',
            'status',
        ]));

        return redirect()
            ->route('admin.contactUs')
            ->with('success', 'Contact details updated successfully');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {

            Auth::guard('admin')->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'You have been logged out.');
        }

        return redirect()->route('login')->withErrors(['message' => 'No admin user was logged in.']);
    }

}
