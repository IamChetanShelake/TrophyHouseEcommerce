<div class="form-group">
    <label for="name">Name</label><span style="color:red;">*</span>
    <input type="text" name="name" class="form-control" value="{{ old('name', $designer->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="email">Email</label><span style="color:red;">*</span>
    <input type="email" name="email" class="form-control" value="{{ old('email', $designer->email ?? '') }}" required>
</div>

<div class="form-group">
    <label for="mobile_no">Mobile No</label><span style="color:red;">*</span>
    <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no', $designer->mobile ?? '') }}" required>
</div>

@if($type == 'create')
<div class="form-group">
    <label for="password">Password</label><span style="color:red;">*</span>
    <input type="password" name="password" class="form-control" required>
</div>
@endif

<div class="form-group">
    <label for="birthday">Birthday</label><span style="color:red;">*</span>
    <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $designer->birthday ?? '') }}" required>
</div>

<div class="form-group">
    <label for="designation">Designation</label>
    <input type="text" name="designation" class="form-control" value="{{ old('designation', $designer->designation ?? '') }}">
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" class="form-control">
    
    @if (!empty($designer->profile_img))
        <div class="mt-2">
            <strong>Current Image:</strong><br>
            <img src="{{ asset('designer_images/' . $designer->profile_img) }}" width="100" alt="Designer Image">
        </div>
    @endif
</div>
