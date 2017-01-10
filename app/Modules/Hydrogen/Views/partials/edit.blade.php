<form class="col s12">
	<div class="row">
		<div class="input-field col s6">
			<input value="{{ $page->slug }}" id="slug" name="slug" type="text">
			<label for="slug">{{ trans('hydrogen::hydrogen.slug') }}</label>
		</div>
		<div class="input-field col s6">
			<input value="{{ $page->page_title }}" id="title" name="title" type="text">
			<label for="title">{{ trans('hydrogen::hydrogen.title') }}</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<textarea value="{{ $page->page_content }}" id="content" name="content" class="materialize-textarea"></textarea>
			<label for="content">{{ trans('hydrogen::hydrogen.content') }}</label>
		</div>
	</div>
</form>
