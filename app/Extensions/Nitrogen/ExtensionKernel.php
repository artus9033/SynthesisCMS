<?php

namespace App\Extensions\Nitrogen;

use App\Extensions\Nitrogen\Models\NitrogenExtension;
use App\Extensions\Nitrogen\Models\NitrogenItem;
use App\Http\Requests\SiteManagerRequest;
use App\Models\Content\Page;
use App\SynthesisCMS\API\Extensions\SynthesisExtension;
use App\SynthesisCMS\API\Extensions\SynthesisExtensionType;
use App\SynthesisCMS\API\Positions\SynthesisPositions;
use App\Toolbox;
use Illuminate\Support\Str;

/**
 * ExtensionKernel
 *
 * Extension Kernel to control all the functionality directly
 * related to the Extension. This class is required, otherwise any routes
 * using this extension will throw an internal CMS error!
 */
class ExtensionKernel extends SynthesisExtension
{
    public function settingsPositionUp(SiteManagerRequest $request, $nr, $id)
    {
        if (NitrogenItem::where(['id' => $id, 'parentInstance' => $nr])->count() == 0) {
            if (NitrogenItem::where(['id' => NitrogenItem::where(['id' => $id, 'parentInstance' => $nr])->first()->before, 'parentInstance' => $nr])->count() == 0) {
                return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
            }
        }
        $item = NitrogenItem::where(['slider' => NitrogenItem::where(['id' => $id, 'parentInstance' => $nr])->first()->slider, 'id' => $id, 'parentInstance' => $nr])->first();
        $slider = $item->slider;
        $item_before_id = $item->before;
        if (NitrogenItem::where(['slider' => $slider, 'id' => $item_before_id, 'parentInstance' => $nr])->count() != 0) {
            $before = NitrogenItem::where(['slider' => $slider, 'id' => $item_before_id, 'parentInstance' => $nr])->first();
            $before_id = $before->id;
            $before_before_id = $before->before;
        } else {
            return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('errors', array(trans('Nitrogen::messages.err_item_cannot_be_moved')));
        }
        if (NitrogenItem::where(['slider' => $slider, 'before' => $item->id, 'parentInstance' => $nr])->count() != 0) {
            $child_item = NitrogenItem::where(['slider' => $slider, 'before' => $item->id, 'parentInstance' => $nr])->first();
            $child_item->before = $before_id;
            $child_item->save();
        }
        $item->before = $before_before_id;
        $before->before = $id;
        $item->save();
        $before->save();
        return redirect()->back()->with('messages', array(trans('Nitrogen::messages.msg_item_moved')));
    }

    public function settingsPositionDown(SiteManagerRequest $request, $nr, $id)
    {
        $instanceModel = NitrogenExtension::find($nr);
        if (NitrogenItem::where(['slider' => $instanceModel->id, 'id' => $id, 'parentInstance' => $nr])->count() == 0) {
            if (NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $id, 'parentInstance' => $nr])->count() == 0) {
                return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
            }
        }
        $item = NitrogenItem::where(['slider' => $instanceModel->id, 'id' => $id, 'parentInstance' => $nr])->first();
        if (NitrogenItem::where(['slider' => $instanceModel->id, 'id' => $item->before, 'parentInstance' => $nr])->count() != 0) {
            $before = NitrogenItem::where(['slider' => $instanceModel->id, 'id' => $item->before, 'parentInstance' => $nr])->first();
            $before_id = $before->id;
        } else {
            $before_id = 0;
        }
        if (NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $id, 'parentInstance' => $nr])->count() != 0) {
            $child_item = NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $id, 'parentInstance' => $nr])->first();
            $child_item->before = $before_id;
            $child_item->save();
            $child_item_id = $child_item->id;
            if (NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $child_item_id, 'parentInstance' => $nr])->count() != 0) {
                $child_item2 = NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $child_item_id, 'parentInstance' => $nr])->first();
                $child_item2->before = $id;
                $child_item2->save();
            }
        } else {
            return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('errors', array(trans('Nitrogen::messages.err_item_cannot_be_moved')));
        }
        $item->before = $child_item_id;
        $item->save();
        return redirect()->back()->with('messages', array(trans('Nitrogen::messages.msg_item_moved')));
    }

    public function settingsDeletePosition(SiteManagerRequest $request, $nr, $id)
    {
        $instanceModel = NitrogenExtension::find($nr);
        $item = NitrogenItem::where(['id' => $id, 'parentInstance' => $nr])->first();
        $after_query = NitrogenItem::where(['slider' => $item->slider, 'before' => $item->id, 'parentInstance' => $nr]);
        if ($after_query->count()) {
            $after = $after_query->first();
            $after->before = $item->before;
            $after->save();
        }
        $slider = $instanceModel->id;
        $children = NitrogenItem::where(['slider' => $slider, 'before' => $id, 'parentInstance' => $nr])->get();
        foreach ($children as $child) {
            $child->delete();
        }
        $item->delete();
        return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('messages', array(trans('Nitrogen::messages.msg_item_deleted')));
    }

    public function settingsEditPositionGet($nr, $id)
    {
        $instanceModel = NitrogenExtension::find($nr);
        $query = NitrogenItem::where(['id' => $id, 'parentInstance' => $nr]);
        if ($query->count() == 0) {
            return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
        } else {
            return view("Nitrogen::partials/edit_item")->with(['model' => $instanceModel, 'kernel' => $this, 'item' => $query->first()]);
        }
    }

    public function settingsEditPositionPost(SiteManagerRequest $request, $nr, $id)
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $titleTextColor = $request->get('titleTextColor');
        $contentTextColor = $request->get('contentTextColor');
        $image = $request->get('image-tv');
        $color = $request->get('bg-color');
        $errors = array();
        $err = false;

        $query = NitrogenItem::where(['id' => $id, 'parentInstance' => $nr]);

        if ($query->count() == 0) {
            return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('errors', array(trans('Nitrogen::messages.err_item_doesnt_exist')));
        }

        if (strlen($title) == 0 || strlen(trim($title)) == 0) {
            $err = true;
            array_push($errors, trans("Nitrogen::messages.err_title_cannot_be_empty"));
        }

        if ($err) {
            return \Redirect::to(\Request::path())->with('errors', $errors);
        } else {
            $item = $query->first();
            $item->title = $title;
            $item->content = $content;
            $item->titleTextColor = $titleTextColor;
            $item->contentTextColor = $contentTextColor;
            $item->image = $image;
            $item->color = $color;
            $item->save();
            return \Redirect::route("applet_settings_with_url", ['extension' => 'Nitrogen', 'url' => ('/' . $nr)])->with('messages', array(trans('Nitrogen::messages.msg_item_saved')));
        }
    }

    public function settingsCreatePositionGet($nr)
    {
        $instanceModel = NitrogenExtension::find($nr);
        return view("Nitrogen::partials/create_item")->with(['model' => $instanceModel, 'kernel' => $this]);
    }

    public function settingsCreatePositionPost(SiteManagerRequest $request, $nr)
    {
        $instanceModel = NitrogenExtension::find($nr);
        $title = $request->get('title');
        $content = $request->get('content');
        $titleTextColor = $request->get('titleTextColor');
        $contentTextColor = $request->get('contentTextColor');
        $image = $request->get('image-tv');
        $color = $request->get('bg-color');
        $errors = array();
        $err = false;

        if (strlen($title) == 0 || strlen(trim($title)) == 0) {
            $err = true;
            array_push($errors, trans("Nitrogen::messages.err_title_cannot_be_empty"));
        }

        if ($err) {
            return \Redirect::to(\Request::path())->with('errors', $errors);
        } else {
            $parent_id = 0;
            if (NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $parent_id, 'parentInstance' => $nr])->count()) {
                $items_raw = NitrogenItem::where(['slider' => $instanceModel->id, 'parentInstance' => $nr]);
                $items_count = $items_raw->count();
                $posctr = 0;
                for ($id = $parent_id; $posctr < $items_count; $posctr++) {
                    $before = NitrogenItem::where(['slider' => $instanceModel->id, 'before' => $id, 'parentInstance' => $nr])->first()->id;
                    $id = $before;
                }
            } else {
                $before = $parent_id;
            }
            $created = NitrogenItem::create(['parentInstance' => $nr, 'image' => $image, 'color' => $color, 'title' => $title, 'content' => $content, 'before' => $before, 'slider' => $instanceModel->id, 'contentTextColor' => $contentTextColor, 'titleTextColor' => $titleTextColor]);
            $created->parentOf = $created->id + 1;
            $created->save();
            return \Redirect::route("applet_settings_with_url", ['extension' => 'Nitrogen', 'url' => ('/' . $nr)])->with(['nr' => $nr, 'model' => $instanceModel, 'kernel' => $this, 'messages' => array(trans('Nitrogen::messages.msg_item_added'))]);
        }
    }

    public function settingsCreateInstancePost(SiteManagerRequest $request)
    {
        $errors_array_ptr = array();
        $hasButton = $request->has('hasButton');
        $buttonText = $request->get('button_text');
        $buttonLink = $request->get('button_link');
        $buttonWavesColor = $request->get('button_waves_color');
        $buttonColor = $request->get('button_color');
        $buttonClass = $request->get('button_class');
        $buttonTextColor = $request->get('button_text_color');
        $buttons = $request->get('buttons');
        $autoplay = $request->get('autoplay');
        $interval = $request->get('interval');
        $title = $request->get("title");
        $assignedPages = "";
        $ctr = 0;
        if ($request->get('assignedToAllPages') != "on") {
            if ($request->get('assigned_pages') && count($request->get('assigned_pages'))) {
                foreach ($request->get('assigned_pages') as $v) {
                    if ($v) {
                        $ctr++;
                        if ($ctr > 1) {
                            $assignedPages .= ";";
                        }
                        $assignedPages .= $v;
                    }
                }
            }
        }
        if ($autoplay == "on") {
            if (!is_numeric($interval)) {
                array_push($errors_array_ptr, trans('Nitrogen::messages.err_interval_must_be_numeric'));
            }
        } else {
            $interval = 0;
        }
        if (empty($title)) {
            array_push($errors_array_ptr, trans('Nitrogen::messages.err_title_cannot_be_empty'));
        }
        if (!empty($errors_array_ptr)) {
            return view("Nitrogen::partials/create_instance")->with(['errors' => $errors_array_ptr]);
        }
        $model = NitrogenExtension::create(['title' => $title, 'enabled' => true, 'buttonText' => $buttonText, 'buttonLink' => $buttonLink, 'buttonWavesColor' => $buttonWavesColor, 'buttonColor' => $buttonColor, 'buttonClass' => $buttonClass, 'buttonTextColor' => $buttonTextColor, 'hasButton' => $hasButton, 'assignedToAllPages' => $request->get('assignedToAllPages') == "on", 'assignedPages' => '', 'buttons' => $buttons == "on", 'autoplay' => $autoplay == "on", 'interval' => $interval]);
        if ($request->get('assignedToAllPages') != "on") {
            $model->assignedPages = $assignedPages;
        }
        $model->save();
        return \Redirect::route("applet_settings", ['extension' => 'Nitrogen'])->with('messages', array(trans('Nitrogen::messages.msg_element_added')));
    }

    public function settingsCreateInstanceGet()
    {
        return view("Nitrogen::partials/create_instance")->with(['kernel' => $this]);
    }

    public function settingsInstanceGet($nr)
    {
        return view('Nitrogen::partials/instance_settings')->with(['model' => NitrogenExtension::find($nr), 'nr' => $nr]);
    }

    public function settingsInstancePost(SiteManagerRequest $request, $nr)
    {
        $errors_array_ptr = array();
        $title = $request->get('title');
        $hasButton = $request->has('hasButton');
        $buttonText = $request->get('button_text');
        $buttonLink = $request->get('button_link');
        $buttonWavesColor = $request->get('button_waves_color');
        $buttonColor = $request->get('button_color');
        $buttonClass = $request->get('button_class');
        $buttonTextColor = $request->get('button_text_color');
        $buttons = $request->get('buttons');
        $autoplay = $request->get('autoplay');
        $interval = $request->get('interval');
        $assignedPages = "";
        $ctr = 0;
        if ($request->get('assignedToAllPages') != "on") {
            if (count($request->get('assigned_pages'))) {
                foreach ($request->get('assigned_pages') as $v) {
                    if ($v) {
                        $ctr++;
                        if ($ctr > 1) {
                            $assignedPages .= ";";
                        }
                        $assignedPages .= $v;
                    }
                }
            }
        }
        if ($autoplay == "on") {
            if (!is_numeric($interval)) {
                array_push($errors_array_ptr, trans('Nitrogen::messages.err_interval_must_be_numeric'));
            }
        } else {
            $interval = 0;
        }
        if ($title == "") {
            array_push($errors_array_ptr, trans('Nitrogen::messages.err_title_cannot_be_empty'));
        }
        if (!empty($errors_array_ptr)) {
            return redirect()->back()->with(['errors' => $errors_array_ptr]);
        }
        $model = NitrogenExtension::find($nr);
        $model->enabled = $request->get('enabled') == "on";
        $model->buttonText = $buttonText;
        $model->buttonLink = $buttonLink;
        $model->buttonWavesColor = $buttonWavesColor;
        $model->buttonColor = $buttonColor;
        $model->buttonClass = $buttonClass;
        $model->hasButton = $hasButton;
        $model->buttonTextColor = $buttonTextColor;
        $model->assignedToAllPages = $request->get('assignedToAllPages') == "on";
        if ($request->get('assignedToAllPages') != "on") {
            $model->assignedPages = $assignedPages;
        }
        $model->buttons = $buttons == "on";
        $model->autoplay = $autoplay == "on";
        $model->interval = $interval;
        $model->title = $title;
        $model->save();
        $count = 0;
        foreach ($request->all() as $key => $val) {
            if (Str::startsWith($key, "item_checkbox")) {
                $item = NitrogenItem::where(['id' => intval(str_replace("item_checkbox", "", $key)), 'parentInstance' => $nr])->first();
                $after_query = NitrogenItem::where(['slider' => $item->slider, 'before' => $item->id, 'parentInstance' => $nr]);
                if ($after_query->count()) {
                    $after = $after_query->first();
                    $after->before = $item->before;
                    $after->save();
                }
                $slider = $model->id;
                $children = NitrogenItem::where(['slider' => $slider, 'before' => $item->id, 'parentInstance' => $nr])->get();
                foreach ($children as $child) {
                    $child->delete();
                }
                $item->delete();
                $count++;
            }
        }
        if ($count == 0) {
            array_push($errors_array_ptr, trans('Nitrogen::messages.err_no_items_selected'));
        }
        return redirect()->back()->with(['messages' => array(trans('Nitrogen::messages.msg_item_saved')), 'errors' => $errors_array_ptr]);
    }

    public function settingsDeleteInstance($id)
    {
        NitrogenExtension::find($id)->delete();
        foreach (NitrogenItem::where(['parentInstance' => $id])->get() as $child) {
            $child->delete();
        }
        return redirect()->back();
    }

    public function settingsGet()
    {
        return view('Nitrogen::partials/settings');
    }

    public function settingsPost(SiteManagerRequest $request, &$errors_array_ptr)
    {
    }

    public function getExtensionName()
    {
        return trans('Nitrogen::nitrogen.name');
    }

    public function getExtensionType()
    {
        return SynthesisExtensionType::Applet;
    }

    public function showSlider($slug)
    {
        $nr = 0;
        $ret = "";
        foreach (NitrogenExtension::all() as $model) {
            if ($model->enabled) {
                $show = false;
                if ($model->assignedToAllPages) {
                    $show = true;
                } else {
                    $pages_assigned_array = explode(";", $model->assignedPages);
                    if (count($pages_assigned_array)) {
                        foreach ($pages_assigned_array as $page_id) {
                            if ($page_id) {
                                $page = Page::where(['id' => $page_id])->first();
                                if ($page && url($page->slug) === $slug) {
                                    $show = true;
                                }
                            }
                        }
                    } else {
                        if (count($model->assignedPages)) {
                            $page = Page::where(['id' => $model->assignedPages])->first();
                            if ($page) {
                                if (url($page->slug) === $slug) {
                                    $show = true;
                                }
                            }
                        }
                    }
                }
                if ($show) {
                    $ret .= view('Nitrogen::index')->with(['kernel' => $this, 'slug' => $slug, 'nr' => $model->id, 'model' => $model]);
                }
            }
        }
        return $ret;
    }

    public function getSliderItems($slug, $nr)
    {
        $out = "";
        $model = NitrogenExtension::find($nr);
        if (!$model) {
            return $out;
        }
        if ($model->hasButton) {
            $out .= "<div class='carousel-fixed-item center'>
			<a href='$model->buttonLink' class='btn waves-effect waves-$model->buttonWavesColor $model->buttonColor $model->buttonClass $model->buttonTextColor-text'>$model->buttonText</a>
			</div>";
        }
        $items_raw = NitrogenItem::where(['slider' => $model->id, 'parentInstance' => $nr]);
        $items_count = $items_raw->count();
        $array = array();
        $posctr = 0;
        for ($id = 0; $posctr < $items_count; $posctr++) {
            $itm = NitrogenItem::where(['slider' => $model->id, 'before' => $id, 'parentInstance' => $nr])->first();
            array_push($array, $itm);
            $id = $itm->id;
        }
        $items = collect($array);
        foreach ($items as $item) {
            if (!$item->image) {
                $background_out = "background-color: " . Toolbox::hex2rgba($item->color, 0.8) . ";";
            } else {
                $background_out = "background-image: url('" . url($item->image) . "');";
            }
            $out .= "<div class='carousel-item' style=\"" . $background_out . "
			background-repeat: no-repeat;
			background-size: cover;
    			background-attachment: fixed;
    			background-position: center; \">
			<h2 class='$item->titleTextColor-text' style='text-shadow:
				-1px -1px 0 #FFFAF0,
				1px -1px 0 #FFFAF0,
				-1px 1px 0 #FFFAF0,
				1px 1px 0 #FFFAF0,
				-1px 0 0 #FFFAF0,
				1px 0 0 #FFFAF0,
				0 1px 0 #FFFAF0,
				0 -1px 0 #FFFAF0;'>
				$item->title
			</h2>
			<p class='$item->contentTextColor-text'>$item->content</p>
			</div>";
        }
        return $out;
    }

    public function hookPositions(&$manager)
    {
        $manager->addStandard(SynthesisPositions::BelowMenu, $this, 'showSlider');
    }
}
