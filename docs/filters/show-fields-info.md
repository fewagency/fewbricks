---
parent: Filters
layout: default
title: show_fields_info
nav_order: 2
permalink: filters/show_fields_info
---

# Fields - show_fields_info

Set to `true` to display info about each field in the backend.
This is separated this from the debug-mode filter (described further down) because while you may want to debug, you
may not necessarily want to clutter the backend with field info at the same time.

## Example

add_filter('fewbricks/show_fields_info', '__return_true');