@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_article_categories')}}
@endsection

@section('side-nav-active', 'manage_article_categories')

@section('breadcrumbs')
	<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ url('/admin/manage_article_categories') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.manage_article_categories') }}</a>
@endsection

@section('main')
	<div class="fixed-action-btn horizontal">
		<button class="btn-floating btn-large pulse {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light z-depth-4 tooltipped"
				data-position="top" data-delay="50"
				data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions') }}">
			<i class="large material-icons">menu</i>
		</button>
		<ul>
			<li>
				<button onclick="toggleAll('.articleCategory_checkbox');"
						class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped"
						data-position="top" data-delay="50"
						data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_swap_selection') }}">
					<i class="large material-icons">swap_horiz</i>
				</button>
			</li>
			<li>
				<button onclick="unselectAll('.articleCategory_checkbox');"
						class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped"
						data-position="top" data-delay="50"
						data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_unselect_all') }}">
					<i class="large material-icons">tab_unselected</i>
				</button>
			</li>
			<li>
				<button onclick="selectAll('.articleCategory_checkbox');"
						class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped"
						data-position="top" data-delay="50"
						data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_select_all') }}">
					<i class="large material-icons">select_all</i>
				</button>
			</li>
		</ul>
	</div>
	<div id="modalMassDelete" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_delete_article_category_header') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_delete_article_category_content') }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_mass_delete_article_category_content_2') }}</strong></h5>
			<div class="col s12">
				<p>
					<input onclick="$('#formMassDeleteChildArticlesCheckbox').prop('checked', $(this).prop('checked'));"
						   class="filled-in {{ $synthesiscmsMainColor }}-text" type="checkbox"
						   id="checkboxDeleteArticles" name="checkboxDeleteArticles">
					<label class="{{ $synthesiscmsMainColor }}-text"
						   for="checkboxDeleteArticles">{{ trans('synthesiscms/admin.modal_mass_delete_article_category_checkbox_delete_subarticles') }}</label>
				</p>
			</div>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassDelete').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_mass_delete_article_category_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_article_categories/mass_delete').submit();"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_delete_article_category_btn_yes') }}</a>
		</div>
	</div>
	<div id="modalMassCopy" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_copy_article_category_header') }}</h3>
			<div class="row col s12">
				<div class="divider green col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_copy_article_category_content') }}</h5>
			<h5 class="green-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_mass_copy_article_category_content_2') }}</strong></h5>
			<div class="col s12">
				<p>
					<input onclick="$('#checkboxMassCopyChildArticlesCheckbox').prop('checked', $(this).prop('checked'));"
						   class="filled-in {{ $synthesiscmsMainColor }}-text" type="checkbox"
						   id="checkboxMassCopyChildArticlesCheckbox" name="checkboxMassCopyChildArticlesCheckbox">
					<label class="{{ $synthesiscmsMainColor }}-text"
						   for="checkboxMassCopyChildArticlesCheckbox">{{ trans('synthesiscms/admin.modal_mass_copy_article_category_checkbox_copy_subarticles') }}</label>
				</p>
			</div>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassCopy').modal('close');"
			   class="modal-action modal-close waves-effect waves-yellow btn-flat right">{{ trans('synthesiscms/admin.modal_mass_copy_article_category_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_article_categories/mass_copy/' + $('#checkboxMassCopyChildArticlesCheckbox').prop('checked')).submit();"
			   class="modal-action green white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_copy_article_category_btn_yes') }}</a>
		</div>
	</div>
	<div id="modalMassMove" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_move_article_category_header') }}</h3>
			<div class="row col s12">
				<div class="divider green col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_move_article_category_content') }}</h5>
			<h5 class="green-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_mass_move_article_category_content_2') }}</strong></h5>
			<div class="col s12">
				<p>
					<input onclick="$('#checkboxMassMoveChildArticlesCheckbox').prop('checked', $(this).prop('checked'));"
						   class="filled-in {{ $synthesiscmsMainColor }}-text" type="checkbox"
						   id="checkboxMassMoveChildArticlesCheckbox" name="checkboxMassMoveChildArticlesCheckbox">
					<label class="{{ $synthesiscmsMainColor }}-text"
						   for="checkboxMassMoveChildArticlesCheckbox">{{ trans('synthesiscms/admin.modal_mass_move_article_category_checkbox_move_subarticles') }}</label>
				</p>
			</div>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassMove').modal('close');"
			   class="modal-action modal-close waves-effect waves-yellow btn-flat right">{{ trans('synthesiscms/admin.modal_mass_move_article_category_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_article_categories/mass_move/' + $('#checkboxMassMoveChildArticlesCheckbox').prop('checked')).submit();"
			   class="modal-action green white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_move_article_category_btn_yes') }}</a>
		</div>
	</div>
	<div>
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">group_work</i>&nbsp;{{ trans('synthesiscms/admin.manage_article_categories') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form class="form col s12 row" id="action_form" method="post">
				{{ csrf_field() }}
				<script>
                    /**
                     * The following code fixes
                     * the problem with the checkbox value
                     * not being submitted with the form
                     **/
                    $(document).ready(function () {
                        $('#formMassDeleteChildArticlesCheckbox').click();
                        $('#formMassDeleteChildArticlesCheckbox').click();
                        $('#checkboxMassCopyChildArticlesCheckbox').click();
                        $('#checkboxMassCopyChildArticlesCheckbox').click();
                    });
                    /**
                     * end of fix
                     **/
				</script>
				<div class="col s12" style="display: none;">
					<p>
						<input id="formMassDeleteChildArticlesCheckbox" name="formMassDeleteChildArticlesCheckbox"
							   class="filled-in {{ $synthesiscmsMainColor }}-text" type="checkbox">
						<label class="{{ $synthesiscmsMainColor }}-text" for="checkboxDeleteArticles">You should not
							see this</label>
					</p>
				</div>
				<table class="col s12">
					<tbody>
					<tr>
						<td><a href="{{ url('/admin/manage_article_categories/create_article_category') }}"
							   class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i
										class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_article_category') }}
							</a></td>
						<td>
							<button onclick="$('#modalMassDelete').modal('open');" type="button"
									class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text left">delete_sweep</i>{{ trans('synthesiscms/article_category.delete_selected') }}
							</button>
						</td>
						<td>
							<button onclick="$('#modalMassCopy').modal('open');" type="button"
									class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text left">content_copy</i>{{ trans('synthesiscms/article_category.copy_selected') }}
							</button>
						</td>
					</tr>
					</tbody>
				</table>
				<div class="col s12 row"></div>
				<div class="col s12 row">
					<table class="bordered col s12">
						<thead>
						<tr>
							<th data-field="check"
								class="center">{{ trans('synthesiscms/article_category.check') }}</th>
							<th data-field="id" class="center">{{ trans('synthesiscms/article_category.id') }}</th>
							<th data-field="title"
								class="center">{{ trans('synthesiscms/article_category.title') }}</th>
							<th data-field="amount"
								class="center">{{ trans('synthesiscms/article_category.amount') }}</th>
							<th data-field="edit"
								class="center">{{ trans('synthesiscms/article_category.edit_article_category') }}</th>
							<th data-field="delete"
								class="center">{{ trans('synthesiscms/article_category.delete_article_category') }}</th>
						</tr>
						</thead>
						<tbody>
						@php
							use \App\Models\Content\ArticleCategory;
							$all_article_categories = ArticleCategory::all();
							$all_article_categories_count = $all_article_categories->count();
						@endphp
						@foreach ($all_article_categories as $articleCategory)
							<tr>
								<td class="right">
									<div class="col s12">
										<p>
											<input class="articleCategory_checkbox filled-in" type="checkbox"
												   id="checkbox{{ $articleCategory->id }}"
												   name="articleCategory_checkbox{{ $articleCategory->id }}">
											<label for="checkbox{{ $articleCategory->id }}"></label>
										</p>
									</div>
								</td>
								<td class="center">{{ $articleCategory->id }}</td>
								<td class="center">{{ \App\Toolbox::string_truncate($articleCategory->title, 15) }}</td>
								<td class="center">{{ $articleCategory->getAmount() }}</td>
								<td class="center"><a
											href="{{ url('/admin/manage_article_categories/edit') }}/{{ $articleCategory->id }}"
											class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i
												class="material-icons white-text left">create</i>{{ trans('synthesiscms/article_category.edit') }}
									</a></td>
								<div id="modalDelete{{ $articleCategory->id }}" class="modal center">
									<div class="modal-content">
										<h3>{{ trans('synthesiscms/admin.modal_delete_article_category_header') }}</h3>
										<div class="row col s12">
											<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
										</div>
										<h5>{{ trans('synthesiscms/admin.modal_delete_article_category_content', ['articleCategory' => $articleCategory->title]) }}</h5>
										<h5 class="red-text darken-1">
											<strong>{{ trans('synthesiscms/admin.modal_delete_article_category_content_2') }}</strong>
										</h5>
										<div class="col s12 row"></div>
										<div class="col s12 center">
											<p class="center">
												<input class="filled-in {{ $synthesiscmsMainColor }}-text"
													   type="checkbox"
													   id="checkboxDeleteArticles{{ $articleCategory->id }}"
													   name="checkboxDeleteArticles{{ $articleCategory->id }}">
												<label class="{{ $synthesiscmsMainColor }}-text"
													   for="checkboxDeleteArticles{{ $articleCategory->id }}">{{ trans('synthesiscms/admin.modal_mass_delete_article_category_checkbox_delete_subarticles') }}</label>
											</p>
										</div>
										<div class="col s12 row"></div>
									</div>
									<div class="modal-footer">
										<a style="margin-right: 9%;"
										   onclick="$('#modalDelete{{ $articleCategory->id }}').modal('close');"
										   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_article_category_btn_no') }}</a>
										<a style="margin-left: 9%;"
										   onclick="window.location.href = ('{{ url('/') }}/admin/manage_article_categories/delete/{{ $articleCategory->id }},' + $('#checkboxDeleteArticles{{ $articleCategory->id }}').prop('checked'));"
										   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_article_category_btn_yes') }}</a>
									</div>
								</div>
								<td class="center">
									<button @php if($articleCategory->id == 1){ echo('disabled'); } @endphp onclick="$('#modalDelete{{ $articleCategory->id }}').modal('open');"
											class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
										<i class="material-icons white-text left">security</i>{{ trans('synthesiscms/article_category.delete_article_category') }}
									</button>
								</td>
							</tr>
						@endforeach
						@if ($all_article_categories_count == 0)
							<tr>
								<td colspan="6"
									class="center">{{ trans('synthesiscms/admin.no_article_categories') }}</td>
							</tr>
						@endif
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function () {
            $('.modal').modal({
                    dismissible: false
                }
            );
        });
	</script>
@endsection
