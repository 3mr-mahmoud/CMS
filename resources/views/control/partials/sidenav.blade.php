<div class="sidebar">
        <div class="sidebar-inner">
          <!-- ### $Sidebar Header ### -->
          <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
              <div class="peer peer-greed">
                <a class="sidebar-link td-n" href="index.html">
                  <div class="peers ai-c fxw-nw">
                    <div class="peer">
                      <div class="logo">
                        <img src="{{ app()->make('url')->to('img/logo.png') }}" alt="">
                      </div>
                    </div>
                    <div class="peer peer-greed">
                      <h5 class="lh-1 mB-0 logo-text">N-tech</h5>
                    </div>
                  </div>
                </a>
              </div>
              <div class="peer">
                <div class="mobile-toggle sidebar-toggle">
                  <a href="" class="td-n">
                    <i class="ti-arrow-circle-left"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- ### $Sidebar Menu ### -->
          <ul class="sidebar-menu scrollable pos-r">
            @can('view',auth()->user())
<li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                  <i class="c-brown-500 ti-email"></i>
                </span>
                <span class="title">{{ __('labels.users') }}</span>
                <span class="arrow">
                  <i class="ti-angle-right"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="{{ controlPanelUrl('users') }}" class='sidebar-link' href="basic-table.html">
                  {{  __('labels.show'). ' '.__('labels.users') }}
                </a>
                </li>
                <li>
                  <a href="{{ controlPanelUrl('users/add') }}" class='sidebar-link' href="basic-table.html">
                  {{  __('labels.add'). ' '.trans_choice('labels.users') }}
                </a>
                </li>
              </ul>
            </li>
            @endcan
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                  <i class="c-blue-500 ti-home"></i>
                </span>
                <span class="title">{{ __('labels.home') }}</span>
                <span class="arrow">
                  <i class="ti-angle-right"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="{{ controlPanelUrl('home') }}" class='sidebar-link' href="basic-table.html">{{ __('labels.generalData') }}</a>
                </li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                  <i class="c-light-blue-500 ti-pencil"></i>
                </span>
                <span class="title">{{ trans_choice('labels.articles',3) }}</span>
                <span class="arrow">
                  <i class="ti-angle-right"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="{{ controlPanelUrl('articles') }}" class='sidebar-link' href="basic-table.html">
                  {{  __('labels.show'). ' '.trans_choice('labels.articles',3) }}
                </a>
                </li>
                <li>
                  <a href="{{ controlPanelUrl('articles/add') }}" class='sidebar-link' href="basic-table.html">
                  {{  __('labels.add'). ' '.trans_choice('labels.articles',1) }}
                </a>
                </li>
              </ul>
            </li>
            

              </ul>
            </li>
          </ul>
        </div>
      </div>