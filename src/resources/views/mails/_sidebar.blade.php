<aside class="w-1/4 flex flex-col">
	<div class="px-2 py-2 mt-2" v-cloak>
		<input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="search" type="search" placeholder="Search" v-model="search">
	</div>

	<div class="px-2 py-2 mt-2" v-cloak>
		<button class="bg-transparent block w-full hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue hover:border-transparent rounded"
				:class="{'opacity-50 cursor-not-allowed': loadingMails}"
				:disabled="loadingMails"
				v-on:click="refresh()"
		>
			<i class="fas fa-spinner fa-spin" v-show="loadingMails"></i>
			<span v-text="loadingMails ? 'Loading...' : 'Refresh'"></span>
		</button>
	</div>

	<section
			v-for="mail in filteredMails"
			class="flex mail-item bg-grey-lightest hover:bg-blue-light text-grey-darker hover:text-white border-b border-blue-light hover:border-transparent py-2 px-3 cursor-pointer"
			:class="{active: currentMail && mail.id == currentMail.id}"
			v-on:click="view(mail)"
			v-cloak
	>
		<div class="w-3/4 text-sm">
			<span>
				@{{ mail.subject }}
			</span>
			<br>
			<span class="text-xs"><strong>To:</strong><span v-html="mail.formattedTo"></span></span>
		</div>
		<div class="w-1/4 text-sm text-right">
			@{{ mail.formattedDate }}
		</div>
	</section>
	<div class="text-4xl text-blue-dark text-center py-4" v-show="loadingMails && firstLoad">
		<i class="fas fa-spinner fa-spin"></i>
	</div>

	<div class="px-2 py-2 mt-2" v-if="mails.next_page_url && !firstLoad" v-cloak>
		<button class="bg-transparent block w-full hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue hover:border-transparent rounded"
		        :class="{'opacity-50 cursor-not-allowed': loadingMails}"
		        :disabled="loadingMails"
		        v-on:click="loadMails()"
		>
			<i class="fas fa-spinner fa-spin" v-show="loadingMails"></i>
			<span v-text="loadingMails ? 'Loading...' : 'Load older'"></span>
		</button>
	</div>

	<p class="text-grey-dark text-center text-lg mt-4" v-if="!loadingMails && _.isEmpty(mails.data)" v-cloak>
		No emails logged.
	</p>
</aside>
