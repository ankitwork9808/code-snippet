// Optimized way to save the sort order to the database using "Sortable Js or Vue draggable next or React beautiful dnd"

    $id = $request->input('id'); //Primary key
    $oldIndex = $request->input('oldIndex'); //old Index by sortable
    $newIndex = $request->input('newIndex'); //new Index by sortable

    if($newIndex > $oldIndex) {
        //Minus sort rule beacuse need to shift item up to fill old gap
        DB::table('blocks')
            ->where('user_id', $this->getId())
            ->where('sort', '<=', $newIndex)
            ->where('sort', '>', $oldIndex)
            ->update([
                'sort' => DB::raw("sort-1")
            ]);

    } else {
        //Plus sort rule beacuse need to shift item down to fill old gap
        DB::table('blocks')
            ->where('user_id', $this->getId())
            ->where('sort', '>=', $newIndex)
            ->where('sort', '<', $oldIndex)
            ->update([
                'sort' => DB::raw("sort+1")
            ]);
    }
// Update the value for current item.
    Block::where('user_id', $this->getId())
        ->where("id", $id)
        ->update([
            "sort" => $newIndex
        ]);
