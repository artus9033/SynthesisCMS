@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_articles')}}
@endsection

@section('side-nav-active-zero-indexed', 0)

@section('head')
	<style>
		#articleCategory-div .caret {
			color: {{ $synthesiscmsMainColor }} !important;
		}

		#articleCategory-div .select-dropdown {
			border-bottom-color: {{ $synthesiscmsMainColor }} !important;
		}
	</style>
@endsection

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_articles') }}"
	   class="breadcrumb">{{ trans('synthesiscms/admin.manage_articles') }}</a>
@endsection

@section('main')
	<div class="fixed-action-btn horizontal">
		<span class="btn-floating btn-large pulse {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light z-depth-4 tooltipped"
			  data-position="top" data-delay="50"
			  data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions') }}">
			<i class="large material-icons">menu</i>
		</span>
		<ul>
			<li>
				<span onclick="toggleAll('.article_checkbox');"
					  class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped"
					  data-position="top" data-delay="50"
					  data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_swap_selection') }}">
					<i class="large material-icons">swap_horiz</i>
				</span>
			</li>
			<li>
				<span onclick="unselectAll('.article_checkbox');"
					  class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped"
					  data-position="top" data-delay="50"
					  data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_unselect_all') }}">
					<i class="large material-icons">tab_unselected</i>
				</span>
			</li>
			<li>
				<span onclick="selectAll('.article_checkbox');"
					  class="btn-floating {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text waves-effect waves-light tooltipped"
					  data-position="top" data-delay="50"
					  data-tooltip="{{ trans('synthesiscms/admin.menu_select_actions_select_all') }}">
					<i class="large material-icons">select_all</i>
				</span>
			</li>
		</ul>
	</div>
	<div id="modalMassDelete" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_delete_article_header') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_delete_article_content') }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_mass_delete_article_content_2') }}</strong></h5>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassDelete').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_mass_delete_article_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="$('#action_form').attr('action', '{{ route('manage_articles_mass_delete_post') }}').submit();"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_delete_article_btn_yes') }}</a>
		</div>
	</div>
	<div id="modalMassMove" class="modal">
		<div class="modal-content">
			<h3>{{ trans('synthesiscms/admin.modal_mass_move_article_header') }}</h3>
			<div class="row col s12">
				<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
			</div>
			<h5>{{ trans('synthesiscms/admin.modal_mass_move_article_content') }}</h5>
			<h5 class="red-text darken-1">
				<strong>{{ trans('synthesiscms/admin.modal_mass_move_article_content_2') }}</strong></h5>
			<div class="row col s12 center">
				<div class="input-field col s8 offset-s2 valign" id="articleCategory-div">
					<select id="massMoveArticleCategory" name="massMoveArticleCategory"
							class="{{ $synthesiscmsMainColor }}-text">
						@foreach (App\Models\Content\ArticleCategory::all() as $key => $value)
							@php
								$option = $value->title . "&nbsp;(ID $value->id)"
							@endphp
							<option value="{{ $value->id }}"
									class="card-panel col s10 offset-s1 red white-text truncate"><h5>{{ $option }}</h5>
							</option>
						@endforeach
					</select>
					<label>{{ trans('synthesiscms/extensions.choose_article_category') }}</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a style="margin-right: 9%;" onclick="$('#modalMassMove').modal('close');"
			   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_mass_move_article_btn_no') }}</a>
			<a style="margin-left: 9%;"
			   onclick="$('#action_form').attr('action', '{{ url('/') }}/admin/manage_articles/mass_move/' + $('#massMoveArticleCategory').val()).submit();"
			   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_mass_move_article_btn_yes') }}</a>
		</div>
	</div>
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper">
					<i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">donut_large</i>&nbsp;{{ trans('synthesiscms/admin.manage_articles') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<form class="form col s12 row" id="action_form" method="post">
				{{ csrf_field() }}
				<table class="col s12">
					<tbody>
					<tr>
						<td>
							<a href="{{ route('create_article') }}"
							   class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable"><i
										class="material-icons white-text left">add</i>{{ trans('synthesiscms/admin.create_article') }}
							</a>
						</td>
						<td>
							<span onclick="$('#modalMassDelete').modal('open');"
								  class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text left">delete_sweep</i>{{ trans('synthesiscms/article.delete_selected') }}
							</span>
						</td>
						<td>
							<span
									onclick="$('#action_form').attr('action', '{{ route('manage_articles_mass_copy_post') }}').submit();"
									class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text left">content_copy</i>{{ trans('synthesiscms/article.copy_selected') }}
							</span>
						</td>
					</tr>
					<tr>
						<td>
							<span onclick="$('#modalMassMove').modal('open');"
								  class="col s10 offset-s1 btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} white-text hoverable waves-effect waves-light">
								<i class="material-icons white-text left">transform</i>{{ trans('synthesiscms/article.move_selected') }}
							</span>
						</td>
					</tr>
					</tbody>
				</table>
				<div class="col s12 row"></div>
				<table class="bordered col s12">
					<thead>
					<tr>
						<th data-field="check" class="center">{{ trans('synthesiscms/article.check') }}</th>
						<th data-field="id" class="center">{{ trans('synthesiscms/article.id') }}</th>
						<th data-field="title" class="center">{{ trans('synthesiscms/article.title') }}</th>
						<th data-field="category"
							class="center">{{ trans('synthesiscms/article.articleCategory') }}</th>
						<th data-field="edit" class="center">{{ trans('synthesiscms/article.edit_article') }}</th>
						<th data-field="delete" class="center">{{ trans('synthesiscms/article.delete_article') }}</th>
					</tr>
					</thead>
					<tbody>
					@php
						use \App\Models\Content\Article;
						$all_articles = Article::all();
						$all_articles_count = $all_articles->count();
					@endphp
					@foreach ($all_articles as $article)
						<tr>
							<td class="right">
								<div class="col s12">
									<p>
										<input class="article_checkbox filled-in" type="checkbox"
											   id="checkbox{{ $article->id }}"
											   name="article_checkbox{{ $article->id }}">
										<label for="checkbox{{ $article->id }}"></label>
									</p>
								</div>
							</td>
							<td class="center">{{ $article->id }}</td>
							<td class="center tooltipped" data-delay="50" data-tooltip="{{ $article->title }}"
								data-position="top">{{ App\Toolbox::string_truncate($article->title, 15) }}</td>
							@php($articleCategoryName = (App\Models\Content\ArticleCategory::find($article->articleCategory)->title  . ' (ID ' . $article->articleCategory . ')'))
							<td class="center tooltipped" data-delay="50" data-tooltip="{{ $articleCategoryName }}"
								data-position="top">{{ App\Toolbox::string_truncate(($articleCategoryName), 15) }}</td>
							<td class="center">
								<a href="{{ route('manage_articles_edit', ['id' => $article->id]) }}"
								   class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
									<i class="material-icons white-text left">create</i>{{ trans('synthesiscms/article.edit') }}
								</a>
							</td>
							<div id="modalDelete{{ $article->id }}" class="modal">
								<div class="modal-content">
									<h3>{{ trans('synthesiscms/admin.modal_delete_article_header') }}</h3>
									<div class="row col s12">
										<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
									</div>
									<h5>{{ trans('synthesiscms/admin.modal_delete_article_content', ['article' => $article->title]) }}</h5>
									<h5 class="red-text darken-1">
										<strong>{{ trans('synthesiscms/admin.modal_delete_article_content_2') }}</strong>
									</h5>
								</div>
								<div class="modal-footer">
									<a style="margin-right: 9%;"
									   onclick="$('#modalDelete{{ $article->id }}').modal('close');"
									   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_article_btn_no') }}</a>
									<a style="margin-left: 9%;"
									   href="{{ route('manage_articles_delete', ['id' => $article->id]) }}"
									   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_article_btn_yes') }}</a>
								</div>
							</div>
							<td class="center">
								<span onclick="$('#modalDelete{{ $article->id }}').modal('open');"
									  class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
									<i class="material-icons white-text left">delete</i>{{ trans('synthesiscms/article.delete_article') }}
								</span>
							</td>
						</tr>
					@endforeach
					@if ($all_articles_count == 0)
						<tr>
							<td colspan="6" class="center">{{ trans('synthesiscms/admin.no_articles') }}</td>
						</tr>
						@endif
					</tbody>
				</table>
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
