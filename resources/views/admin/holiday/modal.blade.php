<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="{{ $typeModal ?? 'exampleModalCenteredScrollable' }}" aria-labelledby="{{ $typeModal ?? 'exampleModalCenteredScrollable' }}" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray bg-clip-padding rounded-md outline-none text-current">
      <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-700 dark:text-gray-200" id="{{ $typeModal ?? 'exampleModalCenteredScrollable' }}Label">
          {{ $titleModal }}
        </h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black dark:text-gray-200 border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ $url }}" autocomplete="off" method="POST">
        @csrf
        @method($method)
        <div class="modal-body relative p-4">
          <label class="flex justify-start flex-col text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400 text-left">Title</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Libur lebaran"
              name="title"
              value="{{ old('title') ?? $title }}"
            />
          </label>
          <label class="flex justify-start flex-col text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400 text-left">Start Date</span>
            <input
              class="block w-full start_date mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Select start date"
              name="start_date"
              value="{{ old('start_date') ?? $startDate }}"
              type="text"
            />
          </label>
          <label class="flex justify-start flex-col text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400 text-left">End Date(optional)</span>
            <input
              class="block end_date w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Select end date(optional)"
              name="end_date"
              value="{{ old('end_date') ?? $endDate }}"
              type="text"
            />
          </label>
          {{--  <label class="flex justify-start flex-col text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400 text-left">Status</span>
            <select
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray"
              name="status"
              id="status"
              style="width: 100%"
            >
              <option value="">Choose of status</option>
              <option value="LIBUR" @if(old('status') == 'LIBUR' || $status == 'LIBUR') selected @endif>Libur</option>
              <option value="CUTI" @if(old('status') == 'CUTI' || $status == 'CUTI') selected @endif>Cuti</option>
            </select>
          </label>  --}}
        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 dark:border-gray-800 rounded-b-md">
          <button type="button"
            class="inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out"
            data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit"
            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
            Save changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>