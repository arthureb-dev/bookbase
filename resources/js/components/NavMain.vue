<script setup lang="ts">
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();

function userHasPermission(permission: string) {
    if (!permission) return true;
    const [domain, action] = permission.split('.');
    return page.props.auth.permissions?.[domain]?.[action] === true;
}

function filterNavItems(items: NavItem[]): NavItem[] {
    return items
        .map((item) => {
            const filteredChildren = item.children ? filterNavItems(item.children) : [];

            const parentPasses = !item.permission || userHasPermission(item.permission);
            const keepItem = parentPasses || filteredChildren.length > 0;

            if (!keepItem) {
                return null;
            }

            return {
                ...item,
                children: filteredChildren,
            };
        })
        .filter(Boolean) as NavItem[];
}

const filteredItems = computed(() => filterNavItems(props.items));

function isOpen(item: NavItem) {
    const url = page.url;
    if (url === item.href || url.startsWith(item.href)) return true;
    return item.children?.some((subItem) => url === subItem.href || url.startsWith(subItem.href)) ?? false;
}
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Menu</SidebarGroupLabel>
        <SidebarMenu>
            <div v-for="item in filteredItems" :key="item.title">
                <Collapsible v-if="item.children && item.children.length" as-child :default-open="isOpen(item)" class="group/collapsible">
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title" :is-active="item.href === page.url">
                                <component v-if="item.icon" :is="item.icon" />
                                <span>{{ item.title }}</span>
                                <ChevronRight class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem v-for="child in item.children" :key="child.title">
                                    <SidebarMenuSubButton as-child :is-active="child.href === page.url">
                                        <Link :href="child.href">
                                            <component v-if="child.icon" :is="child.icon" />
                                            <span>{{ child.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
                <SidebarMenuItem v-else>
                    <SidebarMenuButton as-child :tooltip="item.title" :is-active="item.href === page.url">
                        <Link :href="item.href">
                            <component v-if="item.icon" :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </div>
        </SidebarMenu>
    </SidebarGroup>
</template>
