<div class="mr-2">
    @if (auth()->user()->isOnYearlyPlan())
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg text-sm font-bold"
              style="background: linear-gradient(#36255C, #36255C) padding-box,
                                 linear-gradient(to right, #f59e0b, #a855f7, #ec4899) border-box;
                     border: 2px solid transparent;">
            <span style="background: linear-gradient(to right, #f59e0b, #a855f7, #ec4899);
                         -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                         background-clip: text;">
                ✦ PRO Anual
            </span>
        </span>

    @elseif (auth()->user()->isOnMonthlyPlan())
        <span class="inline-flex items-center px-4 py-1.5 rounded-lg text-sm font-bold border border-purple-secondary/50 text-purple-secondary bg-purple-secondary/10">
            ✦ PRO Mensual
        </span>

    @else
        <a href="{{ route('plans') }}"
           class="inline-flex items-center px-4 py-1.5 rounded-lg text-sm font-medium border border-white/20 text-white/60 hover:text-white hover:border-white/40 transition-all duration-200">
            Actualizar a PRO →
        </a>
    @endif
</div>