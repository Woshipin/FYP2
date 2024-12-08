<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityCategory;

class CommunityCategoryController extends Controller
{
    // public function ShowCommunity()
    // {
    //     $categories = CommunityCategory::all();
    //     return view('community_categories.index', compact('categories'));
    // }

    public function ShowCommunity()
    {
        $communitycategorys = CommunityCategory::all();

        return view('admin.communitycategory',compact('communitycategorys'));
    }

    public function AddCommunity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 自动生成图标逻辑（简单映射，实际可扩展）
        $iconMap = [
            'transport' => 'fa-bus',
            'community' => 'fa-users',
            'social' => 'fa-handshake',
            'cultural' => 'fa-palette',
        ];

        $icon = $iconMap[$request->name] ?? 'fa-circle';

        CommunityCategory::create([
            'name' => $request->name,
            'icon' => $icon,
        ]);

        return redirect()->back()->with('success', 'Community added successfully');
    }

    public function DestroyCommunity(CommunityCategory $communityCategory)
    {
        $communityCategory->delete();

        return redirect()->back()->with('success', 'Community deleted successfully.');
    }


    // public function EditCommunity(CommunityCategory $communityCategory)
    // {
    //     return view('community_categories.edit', compact('communityCategory'));
    // }

    // public function UpdateCommunity(Request $request, CommunityCategory $communityCategory)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     // 更新图标逻辑
    //     $iconMap = [
    //         'transport' => 'fa-bus',
    //         'community' => 'fa-users',
    //         'social' => 'fa-handshake',
    //         'cultural' => 'fa-palette',
    //     ];

    //     $icon = $iconMap[$request->name] ?? 'fa-circle';

    //     $communityCategory->update([
    //         'name' => $request->name,
    //         'icon' => $icon,
    //     ]);

    //     return redirect()->route('community_categories.index')->with('success', 'Category updated successfully');
    // }

}
