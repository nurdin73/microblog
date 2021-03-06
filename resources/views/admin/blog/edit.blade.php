@extends('admin.template.main')
@section('title', 'Update Blog')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Theme included stylesheets -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Update Blog
    </h2>
    <span class="block text-gray-700 dark:text-gray-200 text-sm mb-6">Update Blog post</span>
    @if (session('error'))
      <div class="flex items-center justify-between p-4 mb-9 mt-3 text-sm font-semibold text-red-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-red">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="ml-1">{{ session('error') }}</span>
        </div>
      </div>
    @endif
    @if (session('success'))
      <div class="flex items-center justify-between p-4 mb-9 mt-3 text-sm font-semibold text-red-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-red">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="ml-1">{{ session('success') }}</span>
        </div>
      </div>
    @endif
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
      <form action="{{ route('admin.blogs.update', ['blog' => $blog->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-4 md:grid-cols-2 xl:grid-cols-2">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Title</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Jane Doe"
              name="title"
              value="{{ old('title') ?? $blog->title }}"
            />
            @error('title')
              <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
            @enderror
          </label>
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 mb-2">Tags</span>
            <select id="select2" name="tags[]" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray" multiple>
              @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @if(Arr::where($blog->tags()->get()->toArray(), function($val, $key) use($tag) {
                  return $val['id'] == $tag->id;
                })) selected @endif>{{ Str::limit($tag->name, 20) }}</option>
              @endforeach
            </select>
          </label>
        </div>
        <label for="" class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Content</span>
          <div id="editor" class="w-full mt-3 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
            {!! old('content') ?? $blog->content !!}
          </div>
          <input type="hidden" name="content" value="{!! old('content') ?? $blog->content !!}" id="field-content">
          @error('content')
            <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
          @enderror
        </label>
        <span class="text-gray-700 dark:text-gray-400 block mt-3">Photos <small>(drag the image to sorter)</small></span>
        <div class="grid grid-cols-4 gap-6">
          @foreach ($blog->photos as $photo)
          @php
            if(filter_var($photo->src, FILTER_VALIDATE_URL)) {
                $image = $photo->src;
            } else {
                $image = asset('storage'.$photo->src);
            }
          @endphp
          <div class="grid-cols-1 relative image-list" data-order="{{ $photo->position }}" data-id="{{ $photo->id }}">
            <div class="draggable" draggable="true">
              <img
                src="{{ $image }}"
                class="shadow-lg h-auto"
                alt=""
              />
              <button type="button" data-id="{{ $photo->id }}" class="absolute deleteImage top-0 right-0 px-1 py-1 mt-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
          @endforeach
          <label class="block text-sm">
            {{-- <form action="{{ route('admin.image-upload') }}" method="post" enctype="multipart/form-data" id="formUpload">
              @csrf
              <div>
                <label for="formFileMultiple" class="form-label text-gray-700 dark:text-gray-400">Photos</label>
                <input name="image" accept="image/*" id="uploadImage" class="form-control block w-full px-3 py-1.5 text-base font-normal bg-clip-padding border border-solid rounded transition ease-in-out m-0 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray" type="file" id="formFileMultiple" multiple>
                @error('image')
                  <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
                @enderror
              </div>
            </form> --}}
            <div>
              <label for="formFileMultiple" class="form-label text-gray-700 dark:text-gray-400">Photos</label>
              <input name="image" accept="image/*" id="uploadImage" class="form-control block w-full px-3 py-1.5 text-base font-normal bg-clip-padding border border-solid rounded transition ease-in-out m-0 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray" type="file" id="formFileMultiple" multiple>
              @error('image')
                <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
              @enderror
            </div>
          </label>
        </div>
        <div class="grid grid-cols-2 gap-6 mt-3">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">
              Status
            </span>
            <select
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray"
              name="status"
            >
              <option value="">Choose</option>
              <option value="draft" @if($blog->status == 'draft') selected @endif>Draft</option>
              <option value="published" @if($blog->status == 'published') selected @endif>Published</option>
            </select>
            @error('status')
              <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
            @enderror
          </label>
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Posted date</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Jane Doe"
              name="posted_at"
              value="{{ old('posted_at') }}"
              id="posted_at"
            />
            @error('posted_at')
              <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
            @enderror
          </label>
        </div>
        <div class="flex mt-3">
          <button class="px-4 py-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green" type="submit">
            Save
          </button>
          <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.blogs.index') }}">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>    
@endsection


@section('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Main Quill library -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js" integrity="sha512-t4CFex/T+ioTF5y0QZnCY9r5fkE8bMf9uoNH2HNSwsiTaMQMO0C9KbKPMvwWNdVaEO51nDL3pAzg4ydjWXaqbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css" integrity="sha512-nwpMzLYxfwDnu68Rt9PqLqgVtHkIJxEPrlu3PfTfLQKVgBAlTKDmim1JvCGNyNRtyvCx1nNIVBfYm8UZotWd4Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#select2').select2();
      // var quill = new Quill('#editor', {
      //   theme: 'snow'
      // });
      // quill.on('text-change', function(delta, oldDelta, source) {
      //   $('#field-content').val(quill.root.innerHTML);
      // });

      $('#editor').trumbowyg().on('tbwchange', function(e) {
          $('#field-content').val(e.target.innerHTML);
        });
        // Set HTML content
        $('#editor').trumbowyg('html', "{!! old('content') ?? $blog->content !!}");

      $('#uploadImage').on('change', function() {
        const files = $(this).get(0).files[0];
        const data = new FormData()
        data.append('image', files)
        data.append('blog_id', '{{ $blog->id }}')
        $.ajax({
          url: '{{ route('admin.image-upload') }}',
          method: 'POST',
          data: data,
          contentType: false,
          processData: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            window.location.reload()
          }
        })
      })

      $('.deleteImage').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id')
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#2f8d03',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "delete",
              url: '{{ url('image-delete') }}' + '/' + id,
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function (response) {
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                ).then((result) => {
                  window.location.reload()
                })
              }
            });
          }
        });
      })

      draggable()
      $('#posted_at').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        // applyButtonClasses: 'inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out',
        maxDate: moment().format('YYYY-MM-DD'),
        locale: {
          format: 'YYYY-MM-DD',
        }
      });
    });

    function draggable() {
      let dragStartIndex;
      let beforeDropIndex;
      let idStart;
      let dragHtml;
      const listItems = document.querySelectorAll('.image-list');
      function dragStart() {
        dragStartIndex = this.closest('.image-list').getAttribute('data-order');
        idStart = this.closest('.image-list').getAttribute('data-id');
        dragHtml = this.closest('.image-list').innerHTML;
      }

      function dragOver(e) {
        e.preventDefault();
      }

      function dragEnter() {
          // this.classList.add('is-dragging');
      }

      function dragLeave() {
        // if (dragStartIndex == this.getAttribute('data-order')) {
        //   // listItems[dragStartIndex].classList.add('is-dragging');
        //   if (beforeDropIndex && beforeDropIndex != this.getAttribute('data-order')) {
        //     listItems[beforeDropIndex].classList.remove('is-dragging');
        //   }
        // } else {
        //   // listItems[dragStartIndex].classList.remove('is-dragging');
        //   listItems[this.getAttribute('data-order')].classList.add('is-dragging');
        // }
        beforeDropIndex = this.getAttribute('data-order');
        // this.classList.add('is-dragging');
      }

      function dragDrop() {
        const dragEndIndex = this.getAttribute('data-order');
        const idEnd = this.getAttribute('data-id')
        swapItem(dragStartIndex - 1, dragEndIndex - 1);
        // this.classList.remove('is-dragging');
        // disini endpointnya
        updatePosition(dragEndIndex, idStart)
        updatePosition(dragStartIndex, idEnd)
      }

      function swapItem(from, to) {
        const itemOne = listItems[from].querySelector('.draggable');
        const itemTwo = listItems[to].querySelector('.draggable');

        listItems[from].appendChild(itemTwo);
        listItems[to].appendChild(itemOne);
        listItems[from].classList.remove('is-dragging');
        listItems[to].classList.remove('is-dragging');
      }

      function addEventListeners() {
        const draggables = document.querySelectorAll('.draggable')
        const items = document.querySelectorAll('.image-list')

        draggables.forEach(draggable => {
          draggable.addEventListener('dragstart', dragStart)
        })

        items.forEach(item => {
          item.addEventListener('dragover', dragOver)
          item.addEventListener('dragenter', dragEnter)
          item.addEventListener('dragleave', dragLeave)
          item.addEventListener('drop', dragDrop)
        })
      }

      function updatePosition(position, id) {  
        $.ajax({
          type: "PUT",
          url: '{{ route('admin.change-image-position') }}',
          data: JSON.stringify({
            id: id,
            position: position
          }),
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            Swal.fire({
              text: response.message,
              icon: 'success',
              allowOutsideClick: false
            }).then(() => {
              window.location.reload();
            })
          },
          error: function(err) {
            console.log(err);
          }
        });
      }

      addEventListeners()
  }
  </script>
@endsection