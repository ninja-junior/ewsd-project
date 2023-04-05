<main class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
    <header class="sm:text-center mb-10">
        <div class="space-y-2 space-y-0 space-x-4 mt-8">
            <div class="relative flex inline-flex items-center bg-gray-100 rounded-xl">
                <select id="countries" wire:model.lazy="choose"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="title">Title</option>
                    <option value="content">Content</option>
                    <option value="author">User</option>
                    <option value="category">Category</option>
                    <option value="mostview">Most View</option>
                    <option value="mostvote">Most Vote</option>
                </select>
                <div class="relative flex inline-flex items-center bg-gray-100 rounded-xl ">
                    <div class="flex items-center w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button wire:click="$set('search', '')">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <input type="text" id="simple-search" wire:model="search"
                                wire:keydown.enter="$set('search', '')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search" required>
                        </div>
                    </div>
                </div>
            </div>
    </header>

    @foreach ($posts as $post)
    <div :wire:key="'post-'.$post->id"
        class="relative sm:pb-12 sm:ml-[calc(2rem+1px)] md:ml-[calc(3.5rem+1px)] lg:ml-[max(calc(14.5rem+1px),calc(100%-48rem))]">
        <div
            class="hidden absolute top-3 bottom-0 right-full mr-7 md:mr-[3.25rem] w-px bg-slate-200 dark:bg-slate-400 sm:block">
        </div>

        <div x-data="{more:false}" class="space-y-16">

            <article class="relative group">
                <div
                    class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-slate-100/70 dark:group-hover:bg-slate-800/50">
                </div>
                <svg viewBox="0 0 9 9"
                    class="hidden absolute right-full mr-6 top-2 text-slate-200 dark:text-slate-400 md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block">
                    <circle cx="4.5" cy="4.5" r="4.5" stroke="currentColor" class="fill-white dark:fill-slate-900"
                        stroke-width="2"></circle>
                </svg>
                <div class="relative">
                    <!-- Idea Title -->
                    <div class="lg:flex lg:space-x-4 items-center">
                        <h3
                            class="text-base font-semibold tracking-tight text-slate-900 dark:text-slate-200 pt-8 lg:pt-0">
                            {{ $post->title }}
                        </h3>
                        @if ( $post->views>0)
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm">{{ $post->views }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Idea creator -->
                    By : <a href="{{ route('posts.index')}}?search={{$post->display_name   }}&choose=author"
                        class="relative z-10 font-semibold border-b-2 border-sky-300">
                        {{ $post->display_name }}</a>
                    <div class="mt-2 mb-4  prose-slate prose-a:relative prose-a:z-10 dark:prose-dark  md:flex">
                        <!-- Idea excerpt -->
                        <div class="md:shrink-0 ">
                            <img class="transition ease-in-out delay-150 rounded-md h-32 w-32 mx-auto mb-4 object-cover"
                                {{-- src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg" --}}
                                src="{{ asset('storage/' . $post->image) }}" alt="Modern building architecture">
                        </div>
                        <div class="">

                            <div x-bind:class="more ? 'line-clamp-none' : 'line-clamp-3' "
                                class="text-gray-900 bg:text-white dark:text-white md:pl-6" x-cloak>
                                {!! Str::markdown($post->content) !!}
                            </div>
                        </div>
                    </div>
                    <dl
                        class="absolute left-0 top-0 w-full lg:w-auto lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
                        <div class="flex lg:space-y-2 justify-between lg:flex-col ">

                            <dd class="whitespace-nowrap text-sm leading-6 dark:text-slate-400 text-right">
                                <!-- Idea created_at date -->
                                <time datetime="{{ $post->created_at }}">{{
                                    \Carbon\Carbon::parse($post->created_at)->format('F d, Y')}}</time>
                            </dd>
                            <dd class="right-0 whitespace-nowrap text-sm leading-6 dark:text-slate-400 text-center">
                                <!-- Idea created_at date -->


                                <a href="{{ route('posts.index')}}?search={{$post->category->name  }}&choose=category"
                                    class=" relative z-5 italic font-semibold text-sky-500">
                                    # {{ $post->category->name }}</a>


                            </dd>
                            <!-- voting buttons -->
                            {{-- @livewire('posts.pvote',['post'=>$post]) --}}
                            {{-- <livewire:posts.pvote :post="$post" :wire:key="$post->id"> --}}
                                <div>
                                    <dd
                                        class="right-0 whitespace-nowrap text-sm leading-6 dark:text-slate-400 text-right">
                                        <button wire:click.prevent="vote('up',{{ $post->id }})"
                                            class="ml-2 py-1 px-3 shadow-md rounded-lg dark:bg-gray-800 hover:bg-sky-100">
                                            <span class="text-teal-600 text-semibold">
                                                {{ $post->totalUpVote() }}
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v12m6-6H6" />
                                            </svg>
                                        </button>
                                        <button wire:click.prevent="vote('down',{{ $post->id }})"
                                            class="py-1 px-3 shadow-md rounded-lg dark:bg-gray-800 hover:bg-rose-200">
                                            <span>
                                                {{ $post->totalDownVote() }}
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                            </svg>

                                        </button>
                                    </dd>
                                </div>
                                <!-- end voting -->

                        </div>
                    </dl>
                </div>
                <!-- Link to Idea deail page -->
                <button @click="more=!more" wire:click.prevent="read({{ $post }})"
                    class="flex items-center text-sm hover:text-sky-600 dark:text-sky-300 font-medium">
                    <!-- <span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl">
                    </span> -->
                    <div class="flex items-center" x-show="!more" x-cloak>
                        <span class="relative">Read more</span>
                        <svg class="relative mt-px overflow-visible ml-2.5 text-sky-300 dark:text-sky-500" width="3"
                            height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M0 0L3 3L0 6"></path>
                        </svg>
                    </div>
                    <div class="flex items-center" x-show="more" x-cloak>
                        <span class="relative">Read less</span>
                        <svg class="relative mt-px overflow-visible ml-2.5 text-sky-300 dark:text-sky-500" width="3"
                            height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M0 0L3 3L0 6"></path>
                        </svg>
                    </div>
                </button>

            </article>
            <!-- comments -->
            {{-- @livewire('posts.comments',['post'=>$post]) --}}

            <div x-show="more" x-cloak>
                <div class="flex justify-between items-center mb-6 mt-2">
                    <h2 class="text-lg lg:text-xl font-bold text-gray-900 dark:text-white">Discussion ({{
                        $post->comments->count ()
                        }})
                    </h2>
                </div>
                <!-- comment form -->
                @if ($post->isWithinCommentClosureDate())

                <form wire:submit.prevent="submitComment({{ $post->id }})" class="mb-6">
                    <div class="flex items-center mb-4">
                        <input id="default-checkbox" type="checkbox" wire:model="isAnnonyous"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-checkbox"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Post as
                            Annonyous ?</label>
                    </div>
                    <div
                        class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <label for="comment" class="sr-only">Your comment</label>
                        <textarea id="comment" rows="4" wire:model.lazy="content"
                            class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                            placeholder="Write a comment..." required></textarea>
                    </div>

                    <x-secondary-button>
                        Submit
                    </x-secondary-button>
                    {{-- <button type="submit"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-teal-800 rounded-lg focus:ring-4 focus:ring-teal-200 dark:focus:ring-teal-900 hover:bg-teal-900">
                        Post comment
                    </button> --}}

                </form>
                @endif
                @foreach ($post->comments as $comment)
                <article :wire:key="'comment-'.{{ $comment->id }}"
                    class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                {{ $comment->display_name }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate
                                    datetime="{{ \Carbon\Carbon::parse($comment->created_at)->format('m-d-Y')}}"
                                    title="February 8th, 2022">
                                    {{ \Carbon\Carbon::parse($comment->created_at)->format('F d, Y')}}</time></p>
                        </div>
                        <!-- toggle button -->
                        @if ($userId==$comment->user_id)
                        <div x-data="{
                            open: false,
                            toggle() {
                                if (this.open) {
                                    return this.close()
                                }
                 
                                this.$refs.button.focus()
                 
                                this.open = true
                            },
                            close(focusAfter) {
                                if (! this.open) return
                 
                                this.open = false
                 
                                focusAfter && focusAfter.focus()
                            }
                        }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']" class="relative">
                            <!-- Button -->
                            <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')" type="button"
                                class="flex items-center gap-2 bg-transparent hover:bg-gray-100 py-1 px-2 rounded-md ">


                                <!-- Heroicon: chevron-down -->
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                    </path>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>

                            <!-- Panel -->
                            <div x-ref="panel" x-show="open" x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')"
                                style="display: none;"
                                class="absolute left-0 mt-2 w-40 rounded-md dark:bg-gray-800 bg-gray-100 shadow-md">
                                {{-- <button href="#"
                                    class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500 dark:text-white dark:hover:bg-gray-700">
                                    Edit Task
                                </button> --}}

                                <button type="button" wire:click.prevent="delete({{ $comment->id }})"
                                    class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
                                    <span class="text-red-600">Delete Task</span>
                                </button>
                            </div>
                        </div>
                        @endif


                    </footer>
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ $comment->content }}
                    </p>

                </article>
                @endforeach
            </div>


            <!-- end comments -->

        </div>

    </div>
    @endforeach
    {{--pagination --}}
    <div class="mt-7">
        {{ $posts->links() }}
    </div>
</main>